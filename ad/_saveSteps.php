<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(判断/判定)</TITLE>
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
$entryNo = $_POST['entryNo'];
$entryDate = $_POST['entryDate'];
$requester = $_POST['requester'];
$requesterEmail = $_POST['requesterEmail'];
$reviewerJname = $_POST['reviewerJname'];
$reviewerEmail = $_POST['reviewerEmail'];
$meetingTitle = $_POST['meetingTitle'];
$cRow = $_POST['currentRow'];
$requestNote = $_POST['requestNote'];                     //
$decision = $_POST['decision'];                           //
$closeNote = $_POST['closeNote'];                         //
$statusCode = $_POST['statusCode'];                       //
$backDisplay = $_POST['backDisplay'];
$statusCodeShow = $_POST['statusCodeShow'];
$fiscalYear = $_POST['fiscalYear'];
$OrderDisplay = $_POST['OrderDisplay'];
$_staffOnly = $_POST['so'];
$action = $_POST['action'];

if (isset($_POST['mail_cc']))
  $mail_cc = $_POST['mail_cc'];

$action = implode(",", $action);
if (($action1=strrpos($action,'chk1')) === false)
  $action1 = "blank";
if (($action2=strrpos($action,'chk2')) === false)
  $action2 = "blank";
if (($action3=strrpos($action,'chk3')) === false)
  $action3 = "blank";
/*
echo "action=(".$action1.", ".$action2.", ".$action3.")<br>";
*/
  
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
  
  $statusTime42 = $ws2->getCell('AE'.$cRow)->getValue();
  
  $reviewerJname = $ws2->getCell('O'.$cRow)->getValue();                  // 審査者の氏名
  $testingEmail = $ws1->getCell('B6')->getValue();                        // 試行時のメール送付先アドレス
  
  // データの保存(書込み)
  if (is_numeric($action1)) {
    $statusCode = 33;
    $statusTime33 = date('Y/m/d H:i:s');
    $ws2->setCellValue('AH'.$cRow,$statusTime33);
    $ws2->setCellValue('AA'.$cRow,$statusCode);
    if (!empty($statusTime42))
      $statusCode = 42;
  }
  if (is_numeric($action2)) {
    $statusCode = 42;
    $statusTime42 = date('Y/m/d H:i:s');
    $ws2->setCellValue('AE'.$cRow,$statusTime42);
    $ws2->setCellValue('AA'.$cRow,$statusCode);
  }
  if ($statusCode == 33 || $statusCode == 42) {
//  if (is_numeric($action3)) {
    $decision = "承認";
    $ws2->setCellValue('V'.$cRow,$decision);
    $ws2->setCellValue('W'.$cRow,$closeNote);
//    $statusCode = 52;
    $statusTime52 = date('Y/m/d H:i:s');
    $ws2->setCellValue('AJ'.$cRow,$statusTime52);
//    $ws2->setCellValue('AA'.$cRow,$statusCode);
  }
  
// echo "new-statusCode=(".$statusCode.")<br>";
  
  $writer->save( $excelfilepath );
  
// echo date('H:i:s')."  書込み終了<br>";
  
  
  
  if ($statusCode == 33 || $statusCode == 42) {
    
    // 申請者に送信するメールを作成
    
    if (!strncasecmp(substr($entryNo,3,1),"1",1))
      $requesterEmail = $testingEmail;
    else
      $requesterEmail = $requesterEmail;
//      $requesterEmail = $testingEmail;                                      // ### Mail ###
    $to = $requesterEmail;
    
    $subject = "外部発表審査 (" . $entryNo . ")";
    $header = "From: " . "apache@pec.tsukuba.ac.jp";
    
// echo "Headerr=(".$header.")<br>";
    
    
    $body = $requester . " 様、\n";
    $body .= "\n　表題の件、状況の更新がありましたのでお知らせします。";
    $body .= "\n";
    $body .= "\n　申請番号： " . $entryNo;
    $body .= "\n　　申請日： " . $entryDate;
    $body .= "\n　会議名等： " . mb_strimwidth($meetingTitle, 0, 50, "...", "UTF-8");
    $body .= "\n";
    if ($statusCode == 33)
      $body .= "\n　　　対象： " . "会議/論文のアブストラクト等について";
    else
      $body .= "\n　　　対象： " . "本論文等について";
    $body .= "\n　　　状況： " . "審査完了";
    $body .= "\n";
    $body .= "\n以上";
    $body .= "\n";
    
// echo "Body=(".$body.")<br>";
    
    if(mb_send_mail($to,$subject,$body,$header)) {
      $_msg = "Sucessed!";
    } else {
      $_msg = "Faile in mail sending";
    }
    
// echo date('H:i:s')."  メール送信終了 (".$_msg.")<br>";
    
    
    
    // 審査者に送信するメールを作成
    
    if (!strncasecmp(substr($entryNo,3,1),"1",1))
      $reviewerEmail = $testingEmail;
    else
      $reviewerEmail = $reviewerEmail;
//      $reviewerEmail = $testingEmail;                                      // ### Mail ###
    $to = $reviewerEmail;
    
    $subject = "外部発表審査 (" . $entryNo . ")";
    $header = "From: " . "apache@pec.tsukuba.ac.jp";
    
    $body = $reviewerJname . " 先生、\n";
    $body .= "\n　表題の件、コメントに入力をいただきありがとうございます。";
    $body .= "\n";
    $body .= "\n　申請番号： " . $entryNo;
    $body .= "\n　　申請日： " . $entryDate;
    $body .= "\n　会議名等： " . mb_strimwidth($meetingTitle, 0, 50, "...", "UTF-8");
    $body .= "\n";
    if ($statusCode == 33)
      $body .= "\n　　　対象： " . "会議/論文のアブストラクト等について";
    else
      $body .= "\n　　　対象： " . "本論文等について";
    $body .= "\n　　　状況： " . "審査済み";
    $body .= "\n";
    $body .= "\n以上";
    $body .= "\n";
    
// echo "Body=(".$body.")<br>";
    
    if(mb_send_mail($to,$subject,$body,$header)) {
      $_msg = "Sucessed!";
    } else {
      $_msg = "Failed in mail sending";
    }
    
// echo date('H:i:s')."  メール送信終了 (".$_msg.")<br>";
    
  }
  
  
  switch ($statusCode) {
    case 33:
      $_fromNo = 7;
      $_msg = "location: ../_selector.php?fn=".$_fromNo."&so=".$_staffOnly."&en=".$entryNo."&bD=".$backDisplay."&sCS=".$statusCodeShow."&fy=".$fiscalYear."&od=".$OrderDisplay;
      break;
      
    case 42:
      $_fromNo = 4;
      $_msg = "location: ./_createPDF.php?fn=".$_fromNo."&so=".$_staffOnly."&cr=".$cRow."&sg="."&bD=".$backDisplay."&sCS=".$statusCodeShow."&fy=".$fiscalYear."&od=".$OrderDisplay;
      break;
      
    default:
    
  }
  header($_msg);
  exit;

?>


<BR>　この処理(_saveSteps)は終了しました<BR>
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
