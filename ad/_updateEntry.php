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
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

//  var_dump($_POST);

$cRow = $_POST['cRow'];
$entryNo = $_POST['entryNo'];
$entryDate = $_POST['entryDate'];
$requester = $_POST['requester'];
$requesterEmail = $_POST['requesterEmail'];
$eventTitle = $_POST['eventTitle'];
$author = $_POST['author'];
$meetingTitle = $_POST['meetingTitle'];
$meetingDate = $_POST['meetingDate'];
$abstract = $_POST['abstract'];
$attachment = $_POST['attachment'];
$filename1 = $_POST['filename1'];
$filename2 = $_POST['filename2'];
$filename3 = $_POST['filename3'];
$meetingDateTo = $_POST['meetingDateTo'];
$reviewer = $_POST['reviewer'];
$reviewerEmail = $_POST['reviewerEmail'];
$statusTime22 = $_POST['statusTime22'];
$statusTime32 = $_POST['statusTime32'];
$comment1 = $_POST['comment1'];
$comment2 = $_POST['comment2'];
$statusTime33 = $_POST['statusTime33'];
$statusTime34 = $_POST['statusTime34'];
$decision = $_POST['decision'];
$closeNote = $_POST['closeNote'];
$statusTime42 = $_POST['statusTime42'];
$attachedFile_wo = $_POST['attachedFile_wo'];
$entryNo_status = $_POST['entryNo_status'];
$statusCode = (int)$_POST['statusCode'];
$statusCode_old = (int)$_POST['statusCode_old'];
  
  
  list($reviewerJname, $reviewerEname, $reviewerEmail, $reviewerActive) = explode("!", $reviewer);
  if ($reviewerJname == '-')
    $reviewerJname = "";
  $entryNo_status_fromto = substr($entryNo,3,1) . $entryNo_status;
  Switch ((string)$entryNo_status_fromto) {
    case "01":
    case "10":
      $entryNo_new = substr($entryNo,0,3) . $entryNo_status . substr($entryNo,4);
      break;
    case "00":
    case "11":
    case "88":
    case "99":
      $entryNo_new = $entryNo;
      break;
    default:
      // status, statusTime の更新が必要 --> 対応しない          // ##########
      $entryNo_new = $entryNo;
      break;
  }
  
// echo "old-entryNo=(".$entryNo.")<br>";
// echo "new-entryNo=(".$entryNo_new.")<br>";
  
  if (strcasecmp($statusCode,$statusCode_old)) {
    // statusCodeが変更された場合
    Switch ($statusCode) {
      case 8:
        $col = "Z";
        break;
      case 10:
        $col = "AB";
        break;
      case 22:
        $col = "AC";
        break;
      case 32:
        $col = "AD";
        break;
      case 33:
        $col = "AH";
        break;
      case 34:
        $col = "AI";
        break;
      case 42:
        $col = "AE";
        break;
      case 21:
        $col = "AG";
        break;
      case 52:
        $col = "AJ";
        break;
      default:
        $col = "Z";
    }
    if ($col == "Z")
      $_clock = null;
    else
      $_clock = date('Y/m/d H:i:s');
  } else {
    $_clock = null;
  }
// echo "clock=(". $_clock .")<br>";
  
  
  $meetingDate_month = intval(substr($meetingDate,5,2));
  if ($meetingDate_month < 4)
    $FiscalYear_meeting = intval(substr($meetingDate,0,4))-1;
  else
    $FiscalYear_meeting = intval(substr($meetingDate,0,4));
  
  $entryNo2 = substr($FiscalYear_meeting,2).substr($meetingDate,5,2).substr($meetingDate,8,2).substr($entryNo,3);
  
  $excelfilename = 'EntrySheet.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
  $reader = new XlsxReader;
  $excel = $reader->load($excelfilepath);
  $writer = new Xlsx($excel);
  
  $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
  
/*
$obj2 = $ws2->toArray( null, true, true, true );
var_dump($obj2);
echo "<br/>";
*/
  
  
  // データの保存(書込み)
  $ws2->setCellValue('B'.$cRow,$entryNo_new);
  $ws2->setCellValue('C'.$cRow,$requester);
  $ws2->setCellValue('D'.$cRow,$requesterEmail);
  $ws2->setCellValue('E'.$cRow,$eventTitle);
  $ws2->setCellValue('F'.$cRow,$author);
  $ws2->setCellValue('G'.$cRow,$meetingTitle);
  $ws2->setCellValue('H'.$cRow,$meetingDate);
  $ws2->setCellValue('I'.$cRow,$abstract);
//  $ws2->setCellValue('J'.$cRow,$attachment);
  $ws2->setCellValue('K'.$cRow,$meetingDateTo);
  $ws2->setCellValue('AL'.$cRow,$filename1);
  $ws2->setCellValue('AM'.$cRow,$filename2);
  $ws2->setCellValue('AN'.$cRow,$filename3);
  
//  $ws2->setCellValue('L'.$cRow,$staffJname);
//  $ws2->setCellValue('N'.$cRow,$staffEmail);
  $ws2->setCellValue('O'.$cRow,$reviewerJname);
  $ws2->setCellValue('P'.$cRow,$reviewerEname);
  $ws2->setCellValue('Q'.$cRow,$reviewerEmail);
  $ws2->setCellValue('R'.$cRow,$comment1);
  $ws2->setCellValue('S'.$cRow,$comment2);
  
  $ws2->setCellValue('V'.$cRow,$decision);
  $ws2->setCellValue('W'.$cRow,$closeNote);
  
  $ws2->setCellValue('X'.$cRow,$FiscalYear_meeting);
  $ws2->setCellValue('Y'.$cRow,$entryNo2);
  
  
  $ws2->setCellValue('AA'.$cRow,$statusCode);
  $ws2->setCellValue('AB'.$cRow,$entryDate);
  $ws2->setCellValue('AC'.$cRow,$statusTime22);
  $ws2->setCellValue('AD'.$cRow,$statusTime32);
  $ws2->setCellValue('AH'.$cRow,$statusTime33);
  $ws2->setCellValue('AI'.$cRow,$statusTime34);
  $ws2->setCellValue('AE'.$cRow,$statusTime42);
//  $ws2->setCellValue('AF'.$cRow,$statusTime52);
//  $ws2->setCellValue('AF'.$cRow,$statusTime90);
  $ws2->setCellValue('AK'.$cRow,$attachedFile_wo);
  
  if (isset($_clock))
    $ws2->setCellValue($col.$cRow,$_clock);
  
// echo "_clock=(".$col.", ".$cRow.",-->".$_clock.")<br>";
  
  $writer->save( $excelfilepath );
  
// echo date('H:i:s')."  書込み終了<br>";
  
  
  
  // 添付資料フォルダーを ./ad/data/ から ../../rv/data/ にコピーする
  $src = dirname( __FILE__ ) . '/data/' . $attachment;
  $dst = dirname( __FILE__ ) . '/../rv/data/' . $attachment;
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

?>

<BR>　情報の更新を完了しました。<BR>

<BR>
<FORM method="post" action="./staff_only.php">
  <INPUT type="submit" name="" value="　管理に戻る　">
</FORM>
<BR>

</BODY>
</HTML>
