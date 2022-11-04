<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(管理)</TITLE>
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

$chk_st42 = $_GET['st42'];
$backDisplay = $_GET['bD'];
$fiscalYear = $_GET['fy'];

$_staffOnly = 1;
  
  
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
  
  
  $staff = $ws1->getCell('B4')->getValue();                      // 幹事の氏名とメールアドレス
  list($staffJname, $staffEname, $staffEmail) = explode("!", $staff);
  $testingEmail = $ws1->getCell('B6')->getValue();               // 試行時のメール送付先アドレス
  
  $to = $staffEmail;
//  $to = $testingEmail;                                      // ### Mail ###
  
  $subject = "外部発表審査　(年度一覧ファイル)";
  $from = "apache@pec.tsukuba.ac.jp";
  $fromname = $staffJname;
  
  $header = '';
  $header .= "Content-Type: multipart/mixed; boundary=\"__BOUNDARY__\"\n";
  //  $header .= "Return-Path: " . $from . " \n";
  $header .= "From: " . $from ." \n";
  //  $header .= "Sender: " . $from ." \n";
  //  $header .= "Reply-To: " . $from . " \n";
  //  $header .= "Organization: " . "PRC" . " \n";
  //  $header .= "X-Sender: " . "PRC" . " \n";
  //  $header .= "X-Priority: 3 \n";
//  echo "Header=(".$header.")<br>";
  
  $body1 = "--__BOUNDARY__\n";
  $body1 .= "Content-Type: text/plain; charset=\"ISO-2022-JP\"\n\n";
  $body1 .= $staffJname . " 先生、\n";
  $body1 .= "\n　外部発表審査の手続きにより".$fiscalYear."年度の申請一覧を";
  $body1 .= "\n添付します。";
  $body1 .= "\n";
  $body1 .= "\n以上";
  $body1 .= "\n";
  $body1 .= "--__BOUNDARY__\n";
//  echo "Body1=(".$body1.")<br>";
  
  if ($chk_st42)
    $attachfile = "{$fiscalYear}c-st42.xlsx";
  else
    $attachfile = "{$fiscalYear}c.xlsx";
  
  $filepath = "./yearly/{$attachfile}";
  
  if ($chk_st42)
    sleep(20);
  else
    sleep(5);
  
  if (!file_exists($filepath)) {
    echo "ファイルの処理時間が足りない!?<br>";
    echo "({$filepath}) は存在しません<br>";
  }
  
  $body2 .= "Content-Type: application/octet-stream; name=\"{$attachfile}\"\n";
  $body2 .= "Content-Disposition: attachment; filename=\"{$attachfile}\"\n";
  $body2 .= "Content-Transfer-Encoding: base64\n";
  $body2 .= "\n";
  $body2 .= chunk_split(base64_encode(file_get_contents($filepath)))."\n";
  $body2 .= "--__BOUNDARY__--\n";
//  echo "Body2=(".$body2.")<br>";
  
  
  // メール送信の実行
  $res = mb_send_mail($to, $subject, $body1.$body2, $header);
  if ($res)
    $_msg = "Sucessed!";
  else
    $_msg = "Failed in mail sending :".$res;
  
//  echo date('H:i:s')."  メール送信終了 (".$_msg.")<br>";
  
  
  
  $_fromNo = 30;
  $_msg = "location: ../_selector.php?fn=".$_fromNo."&so=".$_staffOnly."&bD=".$backDisplay."&fy=".$fiscalYear;
  header($_msg);
  exit;

?>


<BR>　この処理(_mailSummary)は終了しました<BR>
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
