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

/*
var_dump($_POST);
*/

$cRow = $_POST['currentRow'];
$entryNo = $_POST['entryNo'];
  
  
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


  // 書込みするデータ
  $entryNo_new = substr($entryNo,0,3)."9".substr($entryNo,4);
  $statusCode = 90;
  $statusTime90 = date('Y/m/d H:i:s');
  
  // データの保存(書込み)
  $ws2->setCellValue('B'.$cRow,$entryNo_new);
  $ws2->setCellValue('AA'.$cRow,$statusCode);
  $ws2->setCellValue('AF'.$cRow,$statusTime90);
  
  $writer->save( $excelfilepath );
  
// echo date('H:i:s')."  書込み終了<br>";

?>

<BR>　情報の更新を完了しました。<BR>

<BR>
<FORM method="post" action="./staff_only.php">
  <INPUT type="submit" name="" value="　管理に戻る　">
</FORM>
<BR>

</BODY>
</HTML>
