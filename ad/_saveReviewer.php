<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(幹事)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>

<BODY>

<?php
// PhpSpreadsheet ライブラリー
require_once "phpspreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

/*
var_dump($_POST);
*/

$entryNo = $_POST['entryNo'];
$entryDate = $_POST['entryDate'];
$requester = $_POST['requester'];
$requesterEmail = $_POST['requesterEmail'];
$eventTitle = $_POST['eventTitle'];
$meetingTitle = $_POST['meetingTitle'];
$cRow = $_POST['currentRow'];
$reviewer = $_POST['reviewer'];                             //
$suggestion = $_POST['suggestion'];                         //
$action = $_POST['ActBtn'];                                 //
$_staffOnly = $_POST['so'];
$backDisplay = $_POST['bD'];
  
  
  $excelfilename = 'EntrySheet.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
  $reader = new XlsxReader;
  $excel = $reader->load($excelfilepath);
  $writer = new Xlsx($excel);
  
  $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
  $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
  
/*
$obj1 = $ws1->toArray( null, true, true, true );
var_dump($obj1);
echo "<br/>";
$obj2 = $ws2->toArray( null, true, true, true );
var_dump($obj2);
echo "<br/>";
*/

  // 幹事の氏名とメールアドレス
  $staffJname = $ws2->getCell('L'.$cRow)->getValue();
  $staffEmail = $ws2->getCell('N'.$cRow)->getValue();
  // 試行時のメール送付先アドレス
  $testingEmail = $ws1->getCell('B6')->getValue();
  
  // echo "((" . trim($action, " 　") . "))<br>";
  
  switch (trim($action, " 　")) {
    case '送信':
      
      // 書込みするデータ
      list($reviewerJname, $reviewerEname, $reviewerEmail) = explode("!", $reviewer);
      $statusCode = 22;
      $statusTime22 = date('Y/m/d H:i:s');
/*
echo "　Jname:(" . $reviewerJname . ") ";
echo "　Ename:(" . $reviewerEname . ") ";
echo "　Email:(" . $reviewerEmail . ") <br>";
echo "　statusCode:(" . $statusCode . ")<br>";
echo "　statusTime22:(" . $statusTime22 . ")<br>";
*/
      // データの保存(書込み)
      $ws2->setCellValue('O'.$cRow,$reviewerJname);
      $ws2->setCellValue('P'.$cRow,$reviewerEname);
      $ws2->setCellValue('Q'.$cRow,$reviewerEmail);
      $ws2->setCellValue('AA'.$cRow,$statusCode);
      $ws2->setCellValue('AC'.$cRow,$statusTime22);
      
      $writer->save( $excelfilepath );
// echo date('H:i:s')."  書込み終了<br>";
      
      
      // 審査者に送信するメールを作成
      if (!strncasecmp(substr($entryNo,3,1),"1",1)) {
        $reviewerEmail = $testingEmail;
      } else {
        $reviewerEmail = $reviewerEmail;
//      $reviewerEmail = $testingEmail;                                      // ### Mail ###
      }
      $to = $reviewerEmail;
// echo "reviewerEmail=(".$reviewerEmail.")<br>";
      
      $subject = "外部発表審査　(審査依頼)";
      $header = "From: " . "apache@pec.tsukuba.ac.jp";
//      $header .= "\nBcc: " . $testingEmail;                       // ##########
      
      $body = $reviewerJname . " 先生、\n";
      $body .= "\n　下記の外部発表審査をお願いします。";
      $body .= "\n";
      $body .= "\n　　申請者： " . $requester . "　(" . $requesterEmail . ")";
      $body .= "\n　申請番号： " . $entryNo;
      $body .= "\n　　申請日： " . $entryDate;
      $body .= "\n　会議名等： " . mb_strimwidth($meetingTitle, 0, 50, "...", "UTF-8");
      $body .= "\n　　　題目： " . mb_strimwidth($eventTitle, 0, 50, "...", "UTF-8");
      $body .= "\n";
      $body .= "\n　以下のURLをクリックして審査内容を記入してください。";
      $body .= "\n　　http://www.prc.tsukuba.ac.jp/papercheck/rv/reviewComment.php?id=" . $entryNo . "";
      $body .= "\n";
      $body .= "\n　なお、上記URLではユーザIDとパスワードを使用します。パスワードは";
      $body .= "\n各自で更新できますので適時に実施お願いします。ユーザIDの変更は幹事に";
      $body .= "\nお知らせください。";
      $body .= "\n　　http://www.prc.tsukuba.ac.jp/papercheck/rv/changePasswd_rv.php";
      $body .= "\n以上";
      $body .= "\n";
      
// echo "Body=(".$body.")<br>";
    
      // メール送信の実行
      if(mb_send_mail($to,$subject,$body,$header)) {
        $_msg = "Sucessed!";
      } else {
        $_msg = "Faile in mail sending";
      }
      
// echo date('H:i:s')."  メール送信終了 (".$_msg.")<br>";
      
      $fromNo = 2;
      $_msg = "location: ../_selector.php?fn=".$fromNo."&so=".$_staffOnly."&en=".$entryNo."&bD=".$backDisplay;
      break;
      
      
    case '差戻し':
      
      // 書込みするデータ
      $statusCode = 21;
      $statusTime21 = date('Y/m/d H:i:s');
// echo "　statusCode:(" . $statusCode . ")<br>";
// echo "　statusTime21:(" . $statusTime21 . ")<br>";
      
      // データの保存(書込み)
      $ws2->setCellValue('AA'.$cRow,$statusCode);
      $ws2->setCellValue('AG'.$cRow,$statusTime21);
      
      $writer->save( $excelfilepath );
      
// echo date('H:i:s')."  書込み終了<br>";
      
      $fromNo = 5;
      $_msg = "location: ./_createPDF.php?fn=".$fromNo."&so=".$_staffOnly."&cr=".$cRow."&sg=".$suggestion."&bD=".$backDisplay;
      break;
      
      
    case '削除':
      
      // 書込みするデータ
      $entryNo_tmp = substr($entryNo,0,3)."9".substr($entryNo,4);
      $statusCode = 90;
      $statusTime90 = date('Y/m/d H:i:s');
// echo "　updated entryNo:(" . $entryNo_tmp . ") <br>";
// echo "　statusCode:(" . $statusCode . ")<br>";
// echo "　statusTime22:(" . $statusTime90 . ")<br>";
      
      // データの保存(書込み)
      $ws2->setCellValue('B'.$cRow,$entryNo_tmp);
      $ws2->setCellValue('AA'.$cRow,$statusCode);
      $ws2->setCellValue('AF'.$cRow,$statusTime90);
      
      $writer->save( $excelfilepath );
// echo date('H:i:s')."  書込み終了<br>";
    
      $fromNo = 8;
      $_msg = "location: ../_selector.php?fn=".$fromNo."&so=".$_staffOnly."&en=".$entryNo."&bD=".$backDisplay;
      break;
      
      
    default:
      $fromNo = 9;
      $_msg = "location: ../_selector.php?fn=".$fromNo."&so=".$_staffOnly."&en=".$entryNo."&bD=".$backDisplay;
  }
  
  
  header($_msg);
  exit;

?>


<BR>　この処理(_saveReviewer)は終了しました<BR>
<BR>　　申請番号: <?php echo $entryNo ?> です<BR>
<BR>
<FORM>
  <?php
  if ($_staffOnly) {
    if ($backDisplay==2) {
      $_msg = "閉じる";
      $_codename = "window.close()";
    } else {
      $_msg = "　管理に戻る　";
      $_codename = "location.href='./staff_only.php'";
    }
  } else {
    if ($backDisplay==2) {
      $_msg = "閉じる";
      $_codename = "window.close()";
    } else {  
      $_msg = "　ホームに戻る　";
      $_codename = "location.href='http://www.prc.tsukuba.ac.jp/papercheck/'";
    }
  }
  ?>
  <INPUT type="button" name="" value="<?php echo $_msg ?>" onclick="<?php echo $_codename ?>">
</FORM>
<BR>

</BODY>
</HTML>
