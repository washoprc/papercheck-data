<?php
echo "I AM HERE0<br>";


require_once "../phpspreadsheet/vendor/autoload.php";
echo "I AM HERE1<br>";


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
echo "I AM HERE2<br>";


$spreadsheet = new Spreadsheet();
echo "I AM HERE3<br>";


$sheet = $spreadsheet->getActiveSheet();
echo "I AM HERE4<br>";


$sheet->setCellValue('B2', 'Hello World !');
echo "I AM HERE5<br>";


$writer = new Xlsx($spreadsheet);
echo "I AM HERE6<br>";


$writer->save('Hello world.xlsx');
echo "I AM HERE7<br>";

?>
