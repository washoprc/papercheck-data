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
  $sRow = $ws1->getCell('A2')->getValue();
  echo "startRow=(".$sRow.")<br>";


/*
  $entryNo = "17-12345";

//  list($year, $serial) = explode("-",$entryNo);

echo "year=(" . $year . ")<br>";
echo "date_y=(" . date('y') . ")<br>";
echo "strncmp=(" . strncasecmp($entryNo,date('y'),2) . ")<br>";
echo "function::(" . check_entryNo($entryNo) . ")<br>";

if (!check_entryNo($entryNo)) {
  $serial = (int)substr($entryNo,3,5);
  $entryNo = substr($entryNo,0,3) . ++$serial;
  echo "in same year -> add one<br>";
}else{
  $entryNo = date('y')."-"."00001";
  echo "start new year -> initialize<br>";
}
  echo $entryNo."<br>";
*/


  $_row = (int)$sRow;
  $_entryNo = $ws2->getCell('B'.$_row)->getValue();
  $_MaxSerial = 0;
  
  while (isset($_entryNo) && $_entryNo != "eol") {
    echo "value=(".$_entryNo.")<br>";
    if (!check_YearOfentryNo($_entryNo)) {
      $_Serial = (int)substr($_entryNo,3,5);
      if ($_Serial > $_MaxSerial) {
        $_MaxSerial = $_Serial;
      }
    }
    
    if ($_row >= 1000) {
      break;
    } else {
      $_row++;
      $_entryNo = $ws2->getCell('B'.$_row)->getValue();
    }
  }
  $_Serial = $_MaxSerial;
  $entryNo = date('y')."-".str_pad(++$_Serial,5,0,STR_PAD_LEFT);
  
  echo "new entrtNo=(".$entryNo.")<br>";
  echo "insertRow=(".$_row.")<br>";


/*
 if strcmp((string)$year,(string)Date('y')){
   $rt = 1;
 }else{
   $rt = 0;
   }
*/
// echo "strcmp=(" . strcmp($year,Date('y')) . ")<br>";
// echo "rt=(" . $rt . ")<br>";


//  $substr = substr($entryNo,3,5);
    
    
    
//  echo "EntryNo=(".$entryNo.")";
//  echo "<br/>";


/*$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
  $writer->save( $excelfilepath );
  echo date('H:i:s');
  echo "Å@èëÇ´çûÇ›äÆóπ<br>";
*/

} else {
  echo "No reader.";
}


function check_YearOfentryNo($entryNumber){
  return strncasecmp($entryNumber,date('y'),2);             // 0:same  other:not same
}


?>

</BODY>
</HTML>