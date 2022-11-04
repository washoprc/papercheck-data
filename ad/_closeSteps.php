<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(幹事2)</TITLE>
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
$backDisplay = $_GET['bD'];
$statusCodeShow = $_GET['sCS'];
$fiscalYear = $_GET['fy'];
  
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
  
  // 幹事の氏名とメールアドレス
  $staffJname = $ws2->getCell('L'.$cRow)->getValue();
  $staffEmail = $ws2->getCell('N'.$cRow)->getValue();
  
  // 試行時のメール送付先アドレス
  $testingEmail = $ws1->getCell('B6')->getValue();
  
  
  // 幹事に送信するメールを作成
  
  //ライブラリ読み込み --- 日本語添付メールを送る
  require("./PHPMailer/jphpmailer.php");
  
  if (!strncasecmp(substr($entryNo,3,1),"1",1)) {
    $staffEmail = $testingEmail;
  } else {
    $staffEmail = $staffEmail;
  //  $staffEmail = $testingEmail;                                      // ### Mail ###
  }
  $to = $staffEmail;
  
  $subject = "外部発表審査　(手続き完了)";
  $from = "apache@pec.tsukuba.ac.jp";
  $fromname = $staffJname;
  
  $body = $staffJname . " 先生、\n";
  $body .= "\n　外部発表審査の手続きにより以下の申請が完了されました。";
  $body .= "\n申請内容などを記録したPDFファイルを添付します。";
  $body .= "\n";
  $body .= "\n　申請番号： " . $entryNo;
  $body .= "\n";
  $body .= "\n以上";
  $body .= "\n";
  
// echo "Body=(".$body.")<br>";
  
  
  $attachfile = "./entry_pdf/".$entryNo.".pdf";
  
  $mail = new JPHPMailer();
  $mail->addTo($to);
  $mail->setFrom($from,$fromname);
  $mail->setSubject($subject);
  $mail->setBody($body);
  $mail->addAttachment($attachfile);
  
  // メール送信の実行
/*  幹事からの依頼によりメール送信を停止する   2017/11/29 9:48
  if (!$mail->send()){
    $_msg = "Fail in mail sending :".$mail->getErrorMessage();
  } else {
    $_msg = "Sucessed!";
  }
*/
  
// echo date('H:i:s')."  メール送信終了 (".$_msg.")<br>";
  
  
  $_msg = "location: ../_selector.php?fn=".$_fromNo."&so=".$_staffOnly."&en=".$entryNo."&bD=".$backDisplay."&sCS=".$statusCodeShow."&fy=".$fiscalYear;
  header($_msg);
  exit;

?>


<BR>　この処理(closeForm)は終了しました<BR>
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
