<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>


<?php
mb_language("Japanese");
// mb_internal_encoding("SJIS");

mb_internal_encoding("UTF-8");



include_once( dirname( __FILE__ ) . '/Classes/PHPExcel.php' );
include_once( dirname( __FILE__ ) . '/Classes/PHPExcel/IOFactory.php' );


echo "folder:(" . dirname( __FILE__ ) . "/Classes/PHPExcel.php<br>";

$excelfilename = 'Book1.xlsx';
$excelfilepath = dirname( __FILE__ ) . '/Data/' . $excelfilename;
echo "Excelfilepath=(" . $excelfilepath . ")<br>";


$reader = PHPExcel_IOFactory::createReader( 'Excel2007' );
echo "reader=(" . $reader . ")<br>";


$excel = $reader->load( $excelfilepath );

$ws1 = $excel->setActiveSheetIndexByName('Entry');          // setActiveSheetIndex(0)

//  $excel->setActiveSheetIndex(0);
//  $excel->getActiveSheet()->getDefaultStyle()->getFont()->setName(mb_convert_encoding('�l�r �S�V�b�N','cp932'));
//  $excel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(11);



  $obj1 = $ws1->toArray( null, true, true, true );
  var_dump($obj1);
  echo "<br/>";





/* *************
$item = $ws1->getCell('B4')->getValue();
echo "D4-title=(".$item.")<br>";

$msg = "1234こんにちはGood afternoon";
$ws1->setCellValue('D6', $msg);



$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$writer->save( $excelfilepath );
echo date('H:i:s') . "　書き込み完了<br>";
 ****************** */


?>

</BODY>
</HTML>