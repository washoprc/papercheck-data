<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(審査)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>
<BODY>



<?php
// PhpSpreadsheet ライブラリー
require_once "../ad/phpspreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");


// var_dump($_POST);

$do = $_POST['do'];
$do = trim(mb_convert_kana($do, "s", 'UTF-8'));
$entryNo = $_POST['entryNo'];
$entryDate = $_POST['entryDate'];
$requester = $_POST['requester'];
$requesterEmail = $_POST['requesterEmail'];
$eventTitle = $_POST['eventTitle'];
$meetingTitle = $_POST['meetingTitle'];
$cRow = $_POST['currentRow'];
$comment1 = $_POST['comment1'];                     //
$comment2 = $_POST['comment2'];                     //
$statusCode = $_POST['statusCode'];
$_staffOnly = $_POST['so'];
  
  
  $excelfilename = 'EntrySheet.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/../ad/data/' . $excelfilename;
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
  
  $staffJname = $ws2->getCell('L'.$cRow)->getValue();              // 幹事の氏名とメールアドレス
  $staffEmail = $ws2->getCell('N'.$cRow)->getValue();
  $reviewerJname = $ws2->getCell('O'.$cRow)->getValue();           // 審査者の氏名
  $testingEmail = $ws1->getCell('B6')->getValue();                 // 試行時のメール送付先アドレス
  
  // データの保存(書込み)
  if ($do == "送信") {
    if ($statusCode == 22) {
      if ($comment1 !== "" && $comment2 == "") {
        $ws2->setCellValue('R'.$cRow,$comment1);
        $statusCode = 32;
        $statusTime32 = date('Y/m/d H:i:s');
        $ws2->setCellValue('AD'.$cRow,$statusTime32);
      } elseif ($comment1 == "" && $comment2 !== "") {
        $ws2->setCellValue('S'.$cRow,$comment2);
        $statusCode = 34;
        $statusTime34 = date('Y/m/d H:i:s');
        $ws2->setCellValue('AI'.$cRow,$statusTime34);
      } else {
        $ws2->setCellValue('R'.$cRow,$comment1);
        $ws2->setCellValue('S'.$cRow,$comment2);
        $statusCode = 34;
        $statusTime34 = date('Y/m/d H:i:s');
        $ws2->setCellValue('AD'.$cRow,$statusTime34);
        $ws2->setCellValue('AI'.$cRow,$statusTime34);
      }
    } elseif ($statusCode == 33) {
      $comment1_prior = $ws2->getCell('R'.$cRow)->getValue();
      $comment2_prior = $ws2->getCell('S'.$cRow)->getValue();
      
        $ws2->setCellValue('S'.$cRow,$comment2);
        $statusCode = 34;
        $statusTime34 = date('Y/m/d H:i:s');
        $ws2->setCellValue('AI'.$cRow,$statusTime34);
/*
      if ($comment1_prior !== "" && $comment2_prior == "") {
        $ws2->setCellValue('S'.$cRow,$comment2);
        $statusCode = 34;
        $statusTime34 = date('Y/m/d H:i:s');
        $ws2->setCellValue('AI'.$cRow,$statusTime34);
      } elseif ($comment1_prior == "" && $comment2_prior !== "") {
        $ws2->setCellValue('R'.$cRow,$comment1);
        $statusCode = 32;
        $statusTime32 = date('Y/m/d H:i:s');
        $ws2->setCellValue('AD'.$cRow,$statusTime32);
      }
*/
    }
    $ws2->setCellValue('AA'.$cRow,$statusCode);
  } elseif ($do == "一時保存") {
    $ws2->setCellValue('R'.$cRow,$comment1);
    $ws2->setCellValue('S'.$cRow,$comment2);
  }
  $writer->save( $excelfilepath );
  
// echo date('H:i:s')."  書込み終了<br>";
  
  if ($do == "送信") {
    // 幹事に送信するメールを作成
    
    if (!strncasecmp(substr($entryNo,3,1),"1",1)) {
      $staffEmail = $testingEmail;
    } else {
      $staffEmail = $staffEmail;
//    $staffEmail = $testingEmail;                                      // ### Mail ###
    }
    $to = $staffEmail;
    $header = "From: " . "apache@pec.tsukuba.ac.jp";
//    $header .= "\nBcc: " . $testingEmail;                       // ##########
    
    $subject = "外部発表審査　(審査)";
    $body = $staffJname . " 先生、\n";
    $body .= "\n　外部発表審査の手続きにより次の申請について審査者による";
    $body .= "\n「審査」の入力が行われました。";
    $body .= "\n";
    $body .= "\n　　申請者： " . $requester . " (" . $requesterEmail . ")";
    $body .= "\n　申請番号： " . $entryNo;
    $body .= "\n　　申請日： " . $entryDate;
    $body .= "\n　会議名等： " . mb_strimwidth($meetingTitle, 0, 50, "...", "UTF-8");
    $body .= "\n　　　題目： " . mb_strimwidth($eventTitle, 0, 50, "...", "UTF-8");
    $body .= "\n　　審査者： " . $reviewerJname . " 先生";
    $body .= "\n";
    $body .= "\n　以下のURLをクリックして次の対応をお願いします。";
    $body .= "\n    http://www.prc.tsukuba.ac.jp/papercheck/ad/conductSteps.php?id=" . $entryNo . "";
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
    
// echo date('H:i:s')."  メール送信終了 (".$_msg.")<br>";
  
  }
  
  
  if ($do == "送信")
    if ($statusCode == 32)
      $fromNo = 3;
    else
      $fromNo = 8;
  else
    $fromNo = 6;
  $_msg = "location: ../_selector.php?fn=".$fromNo."&so=".$_staffOnly."&en=".$entryNo;
  header($_msg);
  exit;

?>


<BR>　この処理(_saveComment)は終了しました<BR>
<BR>　　申請番号: <?php echo $entryNo ?> です<BR>
<BR>
<FORM>
  <?php
  if ($_staffOnly) {
    $_codename = "'../ad/staff_only.php'";
  } else {
    $_codename = "'./index_Comment.php?so=".$_staffOnly."'";
  }
  ?>
  <INPUT type="button" name="" value="　戻る　" onclick="location.href=<?php echo $_codename ?>">
</FORM>
<BR>

</BODY>
</HTML>
