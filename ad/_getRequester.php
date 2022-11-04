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
$requesterEmail = $_POST['requesterEmail'];

$_staffOnly = $_POST['so'];
  
  
  $excelfilename = 'Requesters.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
  $reader = new XlsxReader;
  $excel = $reader->load($excelfilepath);
  
  $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
  $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
  
/*
$obj1 = $ws1->toArray( null, true, true, true );
var_dump($obj1);
echo "<br/>";
*/
  
  $taskcode = substr($task,0,1);
  
  If (!$taskcode) {
    $_requester = "";
    $_createdDate = "";
    $_updatedDate = "";
  } else {
    $_sRow = $ws1->getCell('B'.'2')->getValue();
    $_row = $_sRow;
    $_requesterEmail = $ws2->getCell('C'.$_row)->getValue();
    while ($_requesterEmail != "eol" ) {
      
      if (!strcasecmp($requesterEmail, $_requesterEmail)) {
        $_requester = $ws2->getCell('B'.$_row)->getValue();
        $_createdDate = $ws2->getCell('G'.$_row)->getValue();
        $_updatedDate = $ws2->getCell('H'.$_row)->getValue();
        break;
      }
      
      if ($_row >= 1000 ) {
        break;
      } else {
        $_row++;
        $_requesterEmail = $ws2->getCell('C'.$_row)->getValue();
      }
    }
  }
  
  $_msg = "location: ./maintainRequester.php?tk=".$taskcode."&req=".$_requester."&reqe=".$requesterEmail."&cdt=".$_createdDate."&udt=".$_updatedDate."&so=".$_staffOnly;
  header($_msg);
  exit;

?>


</BODY>
</HTML>
