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
$do = $_POST['do'];
$do = trim(mb_convert_kana($do, "s", 'UTF-8'));
$cRow = $_POST['currentRow'];
$entryNo = $_POST['entryNo'];
$_staffOnly = $_POST['so'];
$mailTo1 = $_POST['mailTo1'];                             //
$mailSubject1 = $_POST['mailSubject1'];                   //
$mailBody1 = $_POST['mailBody1'];                         //
$mailTo2 = $_POST['mailTo2'];                             //
$mailSubject2 = $_POST['mailSubject2'];                   //
$mailBody2 = $_POST['mailBody2'];                         //
if (isset($_POST['mail_cc']))                             //
  $mail_cc = $_POST['mail_cc'];
  
  
  include_once( dirname( __FILE__ ) . '/../functions.php' );
  
  
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
  
  
  $testingEmail = $ws1->getCell('B6')->getValue();                      // 試行時のメール送付先アドレス
  
  // 前回までのメール送信回数
  if (!empty($ws2->getCell('AQ'.$cRow)->getValue()))
    $_mailCnt = (int)$ws2->getCell('AQ'.$cRow)->getValue();
  else
    $_mailCnt = 0;
  
  // メール送信先
  switch ($do) {
    case "申請者へ送信":
      $mailType = "申請者";
      $mailTo = $mailTo1;
      $mailSubject = $mailSubject1;
      $mailBody = $mailBody1;
      break;
    case "審査者へ送信":
      $mailType = "審査者";
      $mailTo = $mailTo2;
      $mailSubject = $mailSubject2;
      $mailBody = $mailBody2;
      break;
    default:
      
  }
  
  
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
  
  
  // 送信メール作成
  if (!strncasecmp(substr($entryNo,3,1),"1",1))
    $requesterEmail = $testingEmail;
  else
    $requesterEmail = $mailTo;
// $requesterEmail = $testingEmail;                                      // ### Mail ###
  $to = $requesterEmail;
  
  $subject = $mailSubject;
  $header = "From: " . "apache@pec.tsukuba.ac.jp";
  $header .= $_str;
//  $header .= "," . "sakamoto@prc.tsukuba.ac.jp";                       // ### Mail ###
  
  $body = $mailBody;
  $body .= "\n";
  
// echo "To=(".$to.")<br>";
// echo "Headerr=(".$header.")<br>";
// echo "Body=(".$body.")<br>";
  
  
  // メール送信の実行
  if(mb_send_mail($to,$subject,$body,$header)) {
    $_msg = "Sucessed!";
  } else {
    $_msg = "Failed in mail sending";
  }
  $mailSendTime = date('Y/m/d H:i:s');
  
// echo $mailSendTime."  メール送信終了 (".$_msg.")<br>";
  
  // データの保存(書込み)
  if ($_msg == "Sucessed!") {
    $cCol = addColumn("AR",$_mailCnt++);
// echo "cCol=(".$cCol.")<br>";
    $_mail = $mailType . "|" .$to . "|" . $header. "|". $subject . "|" . $body . "|" . $mailSendTime;
    $ws2->setCellValue('AQ'.$cRow,$_mailCnt);
    $ws2->setCellValue($cCol.$cRow,$_mail);
    
    $writer->save( $excelfilepath );
    
// echo date('H:i:s')."  書込み終了<br>";
    
  }

?>

<BR>　メール送信を行いました<BR>
<BR>　　送信日時: <?php echo $mailSendTime ?>
<BR>　　送信状況: <?php echo $_msg ?>
<BR>
<BR>
<FORM>
<?php
if (0)
  $_codename = "'./staff_only.php'";
else
  $_codename = "'./conductSteps.php?id=".$entryNo."&so=".$_staffOnly."'";
?>
  <INPUT type="button" name="" value="　戻る　" onclick="location.href=<?php echo $_codename ?>">
</FORM>
<BR>

</BODY>
</HTML>
