<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(管理)</TITLE>
<LINK href="./hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>

<BODY>

<?php
// PhpSpreadsheet ライブラリー
require_once "./ad/phpspreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

// var_dump($_POST);


$userID = $_POST[userID];
$cRow = $_POST['cRow'];
$entryNo = $_POST['entryNo'];
$requester = $_POST['requester'];
$requesterEmail = $_POST['requesterEmail'];
$eventTitle = $_POST['eventTitle'];
$author = $_POST['author'];
$meetingTitle = $_POST['meetingTitle'];
$meetingDate = $_POST['meetingDate'];
$abstract = $_POST['abstract'];
$attachment = $_POST['attachment'];
$meetingDateTo = $_POST['meetingDateTo'];
$entryDate = $_POST['entryDate'];
$attachedFile_wo = $_POST['attachedFile_wo'];
$filename1 = $_POST['filename1'];
$filename2 = $_POST['filename2'];
$filename3 = $_POST['filename3'];
  
  
  $meetingDate_month = intval(substr($meetingDate,5,2));
  if ($meetingDate_month < 4)
    $FiscalYear_meeting = intval(substr($meetingDate,0,4))-1;
  else
    $FiscalYear_meeting = intval(substr($meetingDate,0,4));
  $entryNo2 = substr($FiscalYear_meeting,2).substr($meetingDate,5,2).substr($meetingDate,8,2).substr($entryNo,3);
  
  $nowDate = date('Y/m/d H:i:s');
  $checkFile = $filename1.$filename2.$filename3;
  if ($attachedFile_wo == '有' && $checkFile == '') {
    $statusCode = 8;
    $statusTime10 = $entryDate;
  } else {
    $statusCode = 10;
    $statusTime10 = $nowDate;
  }
  
  $excelfilename = 'EntrySheet.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/ad/data/' . $excelfilename;
  $reader = new XlsxReader;
  $excel = $reader->load($excelfilepath);
  $writer = new Xlsx($excel);
  
  $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
  $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
  
/*
$obj2 = $ws2->toArray( null, true, true, true );
var_dump($obj2);
echo "<br/>";
*/
  
  
  // データの保存(書込み)
//*  $ws2->setCellValue('B'.$cRow,$entryNo);
  $ws2->setCellValue('C'.$cRow,$requester);
//*  $ws2->setCellValue('D'.$cRow,$requesterEmail);
  $ws2->setCellValue('E'.$cRow,$eventTitle);
  $ws2->setCellValue('F'.$cRow,$author);
  $ws2->setCellValue('G'.$cRow,$meetingTitle);
  $ws2->setCellValue('H'.$cRow,$meetingDate);
  $ws2->setCellValue('I'.$cRow,$abstract);
//*  $ws2->setCellValue('J'.$cRow,$attachment);
  $ws2->setCellValue('K'.$cRow,$meetingDateTo);
  $ws2->setCellValue('AA'.$cRow,$statusCode);
  $ws2->setCellValue('AB'.$cRow,$statusTime10);
  $ws2->setCellValue('AK'.$cRow,$attachedFile_wo);
  $ws2->setCellValue('AL'.$cRow,$filename1);
  $ws2->setCellValue('AM'.$cRow,$filename2);
  $ws2->setCellValue('AN'.$cRow,$filename3);
  $ws2->setCellValue('X'.$cRow,$FiscalYear_meeting);
  $ws2->setCellValue('Y'.$cRow,$entryNo2);
  $writer->save( $excelfilepath );
// echo date('H:i:s')."  データの保存(書込み)終了<br>";
  
  
  
  // 添付資料フォルダーを ./ad/data/ から ../../rv/data/ にコピーする
  $src = dirname( __FILE__ ) . '/ad/data/' . $attachment;
  $dst = dirname( __FILE__ ) . '/rv/data/' . $attachment;
// echo "src=(".$src.")...dst=(".$dst.")<br>";
  
  foreach(glob($dst . '/*') as $file) {
    unlink($file);
  }
  
  if ($handle = opendir($src)) {
    while(false !== ($file = readdir($handle))) {
      if (($file != '.') && ($file != '..')) {
        if ( is_dir($src . '/' . $file) ) {
          recurse_copy($src . '/' . $file,$dst . '/' . $file);
        } else {
          copy($src . '/' . $file,$dst . '/' . $file);
        }
      }
    }
    closedir($handle);
  }
// echo date('H:i:s')."  添付資料フォルダーを ./ad/data/ から ../../rv/data/ にコピー完了<br>";
  
  
  
  // 幹事の氏名とメールアドレス
  $staffJname = $ws2->getCell('L'.$cRow)->getValue();
  $staffEmail = $ws2->getCell('N'.$cRow)->getValue();
// echo "staff: Jname=(".$staffJname."), Email=(".$staffEmail.")<br>";
  
  // 試行時のメール送付先アドレス
  $testingEmail = $ws1->getCell('B6')->getValue();
// echo "testingEmail=(".$testingEmail.")<br>";
  
  // CCメールアドレス
  $sRow_reviewer = intval($ws1->getCell('B8')->getValue());
  $_str = "";
  for ($ii=1; $ii <= sizeof($mail_cc); $ii++) {
    $_row = $sRow_reviewer;
    $_reviewer = $ws1->getCell('B'.$_row)->getValue();
    while ($_reviewer != "eol" ) {
      list($_reviewerJname, $_reviewerEname, $_reviewerEmail, $_reviewerActive) = explode("!", $_reviewer);
      
      if ($mail_cc[$ii-1] == $_reviewerJname) {
        if (!empty($_str))
          $_str .= ",";
          
        $_str .= $_reviewerEmail;
        break;
      }
      
      if ($_row >= 1000 ) {
        break;
      } else {
        $_row++;
        $_reviewer = $ws1->getCell('B'.$_row)->getValue();
      }
    }
  }
  if (!empty($_str))
    $_str = "\nCc: " . $_str;
// echo "CCmail=(".$_str.")<br>";



  // 幹事に申請通知のメールを送る
  if (!strncasecmp(substr($_id,3,1),"1",1)) {
    $staffEmail = $testingEmail;
  } else {
    $staffEmail = $staffEmail;
// $staffEmail = $testingEmail;                                      // ### Mail ###
  }
  $to = $staffEmail;
// echo "To=(".$to.")<br>";
  
  if ($statusCode == 10) {
    $subject = "外部発表審査　(審査者設定)";
  } else {
    $subject = "外部発表審査　(申請受付-資料未添付)";
  }
  $header = "From: " . "apache@pec.tsukuba.ac.jp";
//  $header .= "\nBcc: " . $testingEmail;                                     // ##########
// echo "Headerr=(".$header.")<br>";
  
  $body = $staffJname . " 先生、\n";
  $body .= "\n　外部発表審査の手続きにより以下の申請(再)がありました。";
  $body .= "\n";
  $body .= "\n　　申請者： " . $requester . " (" . $requesterEmail . ")";
  $body .= "\n　申請番号： " . $entryNo;
  $body .= "\n　　申請日： " . $statusTime10;
  $body .= "\n　会議名等： " . mb_strimwidth($meetingTitle, 0, 50, "...", "UTF-8");
  $body .= "\n　　　題目： " . mb_strimwidth($eventTitle, 0, 50, "...", "UTF-8");
  
  if ($statusCode == 10) {
    $body .= "\n";
    if ($attachedFile_wo == "有")
      $body .= "\n　この申請に概要などの説明資料が添付されました。";
    $body .= "\n　以下のURLをクリックして審査者の設定を行ってください。";
    $body .= "\n    http://www.prc.tsukuba.ac.jp/papercheck/ad/assignReviewer.php?id=" . $entryNo . "";
  } else {
    $body .= "\n";
    $body .= "\n　概要などの説明資料が添付できた後、再度通知されます。";
    $body .= "\n　その時まで手続きは保留されます。";
  }
  $body .= "\n";
  $body .= "\n以上";
  $body .= "\n";
// echo "Body=(".$body.")<br>";
  
  // メール送信の実行
  if(mb_send_mail($to,$subject,$body,$header)) {
    $_msg = "Sucessed!";
  } else {
    $_msg = "Failed in mail sending";
  }
// echo date('H:i:s')."  幹事へのメール送信終了 (".$_msg.")<br>";
  
  
  
  // 申請者に受付通知のメールを送る
  if (!strncasecmp(substr($_id,3,1),"1",1)) {
    $requesterEmail = $testingEmail;
  } else {
    $requesterEmail = $requesterEmail;
// $requesterEmail = $testingEmail;                                      // ### Mail ###
  }
  $to = $requesterEmail;
// echo "To=(".$to.")<br>";
  
  if ($statusCode == 10) {
    $subject = "外部発表審査　(申請受付)";
  } else {
    $subject = "外部発表審査　(申請受付-資料未添付)";
  }
  $header = "From: " . "apache@pec.tsukuba.ac.jp";
  $header .= $_str;
//  $header .= "\nBcc: " . $testingEmail;                                     // ##########
// echo "Headerr=(".$header.")<br>";
  
  $body = $requester . " 様、\n";
  $body .= "\n　外部発表審査の手続きにより以下の申請(再)を受付けました。";
  $body .= "\n";
  $body .= "\n　申請番号： " . $entryNo;
  $body .= "\n　　申請日： " . $statusTime10;
  $body .= "\n　会議名等： " . mb_strimwidth($meetingTitle, 0, 50, "...", "UTF-8");
  $body .= "\n　　　題目： " . mb_strimwidth($eventTitle, 0, 50, "...", "UTF-8");
  $body .= "\n";
  $body .= "\n　申請は申請履歴で確認できます。";
  $body .= "\n    http://www.prc.tsukuba.ac.jp/papercheck/index.html";
  $body .= "\n　その際に入力するパスワードは、初回時にメールアドレスのユーザ名で";
  $body .= "\n　仮設定されています。　適時に更新してください。";
  
  if ($statusCode == 10) {
    $body .= "\n";
    if ($attachedFile_wo == "有")
      $body .= "\n　この申請に概要などの説明資料が添付されましたので審査手続きを開始します。";
  } else {
    $body .= "\n";
    $body .= "\n　概要などの説明資料が準備できたら申請履歴を開き、該当の申請番号に";
    $body .= "\n　ある「待機」をクリックしてファイルを添付してください。";
    $body .= "\n　その後、審査手続きが開始されます。";
  }
  $body .= "\n";
  $body .= "\n以上";
  $body .= "\n";
// echo "Body=(".$body.")<br>";
  
  // メール送信の実行
  if(mb_send_mail($to,$subject,$body,$header)) {
    $_msg = "Sucessed!";
  } else {
    $_msg = "Failed in mail sending";
  }
// echo date('H:i:s')."  申請者へのメール送信終了 (".$_msg.")<br>";
  
  
  
  // 申請画面を表示する
  $_codename = "./index_Form.php?uid=".$userID;
  $_msg = "location: ".$_codename;
  
  header($_msg);
  exit;  
?>


<BR>　申請情報の更新(_updateForm)を完了しました。<BR>
<BR>
<BR>
<FORM>
  <INPUT type="button" name="" value="　申請履歴に戻る　" onclick="location.href='<?php echo $_codename ?>'">
</FORM>
<BR>

</BODY>
</HTML>
