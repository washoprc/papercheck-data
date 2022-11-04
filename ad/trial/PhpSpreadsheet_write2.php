<?php
echo "I AM HERE0<br>";


require_once "../phpspreadsheet/vendor/autoload.php";
echo "I AM HERE1<br>";


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
echo "I AM HERE2<br>";


// $spreadsheet = new Spreadsheet();
$excelfilename = 'Hello world.xlsx';
$excelfilepath = dirname( __FILE__ ) . '/' . $excelfilename;
echo "(" . $excelfilepath . ")<br>";


$reader = new XlsxReader;
$spreadsheet = $reader->load($excelfilepath);
echo "I AM HERE3<br>";


// $sheet = $spreadsheet->getActiveSheet();
$sheet = $spreadsheet->getSheetByName("Worksheet");
echo "I AM HERE4<br>";


$sheet->setCellValue('B4', 'Update this');
echo "I AM HERE5<br>";


$writer = new Xlsx($spreadsheet);
echo "I AM HERE6<br>";


$writer->save($excelfilepath);
echo "I AM HERE7<br>";

?>
