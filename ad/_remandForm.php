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

//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

/*
var_dump($_GET);
*/

$_fromNo = $_GET['fn'];
$_staffOnly = $_GET['so'];
$cRow = $_GET['cr'];
$suggestion = $_GET['sg'];
  
  $excelfilename = 'EntrySheet.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
  $reader = new XlsxReader;
  $excel = $reader->load($excelfilepath);
  
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
  
  $entryNo = $ws2->getCell('B'.$cRow)->getValue();
  $entryDate = $ws2->getCell('AB'.$cRow)->getValue();
  $requester = $ws2->getCell('C'.$cRow)->getValue();
  $requesterEmail = $ws2->getCell('D'.$cRow)->getValue();
  $eventTitle = $ws2->getCell('E'.$cRow)->getValue();
  $author = $ws2->getCell('F'.$cRow)->getValue();
  $meetingTitle = $ws2->getCell('G'.$cRow)->getValue();
  $meetingDate = $ws2->getCell('H'.$cRow)->getValue();
  $abstract = $ws2->getCell('I'.$cRow)->getValue();
  
  $staffJname = $ws2->getCell('L'.$cRow)->getValue();
  $staffEmail = $ws2->getCell('N'.$cRow)->getValue();
  $testingEmail = $ws1->getCell('B6')->getValue();               // 試行時のメール送付先アドレス
  
  
  // 申請者に送信するメールを作成
  if (!strncasecmp(substr($entryNo,3,1),"1",1)) {
    $requesterEmail = $testingEmail;
  } else {
    $requesterEmail = $requesterEmail;
// $requesterEmail = $testingEmail;                                      // ### Mail ###
  }
  
  //ライブラリ読み込み --- 日本語添付メールを送る
  require("./PHPMailer/jphpmailer.php");
  
  $to = $requesterEmail;
  $subject = "外部発表審査　(差戻し)";
  $from = "apache@pec.tsukuba.ac.jp";
  $fromname = $staffJname;
  
  $body = $requester . " 様、\n";
  $body .= "\n　外部発表審査の手続きにより貴方から申請がありましたが";
  $body .= "\以下の理由により差戻しとなりました。";
  $body .= "\n　添付ファイルは申請内容です。";
  $body .= "\n";
  $body .= "\n理由：";
  $body .= "\n　" . $suggestion;
  $body .= "\n";
  $body .= "\n以上";
  $body .= "\n";
  
// echo "Body=(".$body.")<br>";
  
  $attachfile = "./tmp/entry.pdf";
  
  $mail = new JPHPMailer();
  $mail->addTo($to);
  $mail->setFrom($from,$fromname);
  $mail->setSubject($subject);
  $mail->setBody($body);
  $mail->addAttachment($attachfile);
  
  // メール送信の実行
  if (!$mail->send()){
    $_msg = "Fail in mail sending :".$mail->getErrorMessage();
  } else {
    $_msg = "Sucessed!";
  }
  
// echo date('H:i:s')."  メール送信終了 (".$_msg.")<br>";
  
  
  
  $_msg = "location: ../_selector.php?fn=".$_fromNo."&so=".$_staffOnly."&en=".$entryNo;
  header($_msg);
  $entryNo = "";
  exit;

?>


<BR>　この処理(remandForm)は終了しました<BR>
<BR>　　申請番号: <?php echo $entryNo ?> です<BR>
<BR>
<FORM>
  <?php
  if ($_staffOnly) {
    $_codename = "'./staff_only.php'";
  } else {
    $_codename = "'http://www.prc.tsukuba.ac.jp/papercheck/'";
  }
  ?>
  <INPUT type="button" name="" value="　戻る　" onclick="location.href=<?php echo $_codename ?>">
</FORM>
<BR>

</BODY>
</HTML>
