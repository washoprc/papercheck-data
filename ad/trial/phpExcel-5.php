<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>
<?php


// mb_language("Japanese");
// mb_internal_encoding("SJIS");

// mb_internal_encoding("UTF-8");


//. PHPExcel ÉâÉCÉuÉâÉäÇ???ûÇ›
include_once( dirname( __FILE__ ) . '/Classes/PHPExcel.php' );
include_once( dirname( __FILE__ ) . '/Classes/PHPExcel/IOFactory.php' );

//. endsWith ä?îÇ?Ëã`
function endsWith( $str, $suffix ){
  $len = strlen( $suffix );
  return $len == 0 || substr( $str, strlen( $str ) - $len, $len ) === $suffix;
}

//. ë??tÉ@ÉCÉãñº
$excelfilename = 'EntrySheet.xlsx';
$excelfilepath = dirname( __FILE__ ) . '/Data/' . $excelfilename;

//. ÉtÉ@ÉCÉãägí£éqÇ?ÊÇ¡Ç?äÅ[É_Å[ÉCÉìÉXÉ^ÉìÉXÇï?¶ÇÈ
$reader = null;
if( endsWith( $excelfilename, 'xls' ) ){
  $reader = PHPExcel_IOFactory::createReader( 'Excel5' );
}else if( endsWith( $excelfilename, 'xlsx' ) ){
  $reader = PHPExcel_IOFactory::createReader( 'Excel2007' );
}

echo endsWith( $excelfilename, 'xlsx' );
echo "<br/>";

echo dirname( __FILE__ );
echo "<br/>";



if( $reader ){
  // Excel file profile
  $excel = $reader->load( $excelfilepath );
  echo $excel->getSheetCount();                           // number of sheets
  echo "<br/>";

  $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
  $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
  

  $excel->setActiveSheetIndex(0);
//  $excel->getActiveSheet()->getDefaultStyle()->getFont()->setName(mb_convert_encoding('ÇlÇr ÉSÉVÉbÉN','cp932'));
//  $excel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(11);


 
   
  //  . FormulaÇåvéZÇ∑ÇÈéwíËÇ?AÉNÉeÉBÉuÉVÅ[ÉgÇ?‡óeÇéèÔÇ∑ÇÈ
  $obj1 = $ws1->toArray( null, true, true, true );
  var_dump($obj1);
  echo "<br/>";
  $obj2 = $ws2->toArray( null, true, true, true );
  var_dump($obj2);
  echo "<br/>";

  
  //. 
  $cRow = $ws1->getCell('A3')->getValue();
  echo "cRow=(".$cRow.")<br>";
//  echo "<br/>";


  $entryNo = "17-00000";
  $entryDate = "entryDate";
  $requester = "requester";
  $requesterEmail = "requesterEmail";
  $subject = "subject";
  $meetingTitle = "meetingTitle";
  $meetingDate = "meetingDate";
  $summary = "summary";

  
  $ws2->setCellValue('B'.$cRow,$entryNo);
  $ws2->setCellValue('C'.$cRow,$entryDate);
  $ws2->setCellValue('D'.$cRow,$requester);
  $ws2->setCellValue('E'.$cRow,$requesterEmail);
  $ws2->setCellValue('F'.$cRow,$subject);
  $ws2->setCellValue('G'.$cRow,$meetingTitle);
  $ws2->setCellValue('H'.$cRow,$meetingDate);
  $ws2->setCellValue('I'.$cRow,$summary);
  

/*
  $entryNo = $ws2->getCell('B'.$cRow)->getValue();
  $entryDate = $ws2->getCell('C'.$cRow)->getValue();
  $requester = $ws2->getCell('D'.$cRow)->getValue();
  $requesterEmail = $ws2->getCell('E'.$cRow)->getValue();
  $subject = $ws2->getCell('F'.$cRow)->getValue();
  $meetingTitle = $ws2->getCell('G'.$cRow)->getValue();
  $meetingDate = $ws2->getCell('H'.$cRow)->getValue();
  $summary = $ws2->getCell('I'.$cRow)->getValue();
*/  
  
  
    
    
    
    
  echo "EntryNo=(".$entryNo.")";
  echo "<br/>";

  
//  $ws2->setCellValue('B5','17-00000');

//  $excel->getActiveSheet()->setCellValue('C10','abcd');
//  $excel->getActiveSheet()->setCellValue('C12',mb_convert_encoding('Ç±ÇÒÇ?øÇÕ', 'UTF-8', 'UTF-8'));
//  $excel->getActiveSheet()->setCellValue('C12','Ç±ÇÒÇ?øÇÕ');

  // Excel2007å`éÆ(xlsx)Ç?oó?∑ÇÈ
  $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
  $writer->save( $excelfilepath );
  echo date('H:i:s');
  echo "Å@èëÇ´çûÇ›äÆóπ<br>";
//  echo "<br/>";

} else {
  echo "No reader.";
}
?>

</BODY>
</HTML>