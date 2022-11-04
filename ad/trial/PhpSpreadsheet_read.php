<?php
echo "I AM HERE0<br>";


require_once "../phpspreadsheet/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
echo "I AM HERE1<br>";


$reader = new XlsxReader;
echo "I AM HERE2<br>";


$excelfilename = 'EntrySheet.xlsx';
$excelfilepath = dirname( __FILE__ ) . '/../data/' . $excelfilename;
echo "(" . $excelfilepath . ")<br>";


$spreadsheet = $reader->load($excelfilepath);
echo "I AM HERE3<br>";


$sheet = $spreadsheet->getSheetByName("Entry");
echo "I AM HERE4<br>";


echo "Entry.B5=(". $sheet->getCell("B5")->getValue() . "]<br>";
echo "I AM HERE5<br>";

?>
