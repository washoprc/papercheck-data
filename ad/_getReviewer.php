<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<TITLE>PRC_外部発表審査(管理)</TITLE>
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
var_dump($_POST);
*/

$task = $_POST['task'];
$reviewerEname = $_POST['reviewerEname'];

$_staffOnly = $_POST['so'];
  
  
  $excelfilename = 'EntrySheet.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
  $reader = new XlsxReader;
  $excel = $reader->load($excelfilepath);
  
  $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
  
/*
$obj1 = $ws1->toArray( null, true, true, true );
var_dump($obj1);
echo "<br/>";
*/
  
  $sRow_reviewer = intval($ws1->getCell('B8')->getValue());
  
  $taskcode = substr($task,0,1);
  
  If (!$taskcode) {
    $_reviewer = "";
    $_updatedDate = "";
  } else {
    
    $_row = $sRow_reviewer;
    $_reviewer = $ws1->getCell('B'.$_row)->getValue();
    while ($_reviewer != "eol" ) {
      
      list($_reviewerJname, $_reviewerEname, $_reviewerEmail, $_reviewerActive) = explode("!", $_reviewer);
      
      if (!strcasecmp($reviewerEname, $_reviewerEname)) {
        $_updatedDate = $ws1->getCell('E'.$_row)->getValue();
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
  
  $_msg = "location: ./maintainReviewer.php?tk=".$taskcode."&rv=".$_reviewer."&udt=".$_updatedDate."&so=".$_staffOnly;
  header($_msg);
  exit;

?>


</BODY>
</HTML>
