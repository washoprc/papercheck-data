<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>
<?php


// mb_language("Japanese");
// mb_internal_encoding("SJIS");

// mb_internal_encoding("UTF-8");


//. PHPExcel ライブラリの読み込み
include_once( dirname( __FILE__ ) . '/Classes/PHPExcel.php' );
include_once( dirname( __FILE__ ) . '/Classes/PHPExcel/IOFactory.php' );

//. endsWith 関数の定義
function endsWith( $str, $suffix ){
  $len = strlen( $suffix );
  return $len == 0 || substr( $str, strlen( $str ) - $len, $len ) === $suffix;
}

//. 対象ファイル名
$excelfilename = 'Book1.xlsx';
$excelfilepath = dirname( __FILE__ ) . '/Data/' . $excelfilename;

//. ファイル拡張子によってリーダーインスタンスを変える
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
  //. エクセルファイルを読み込む
  $excel = $reader->load( $excelfilepath );
  echo $excel->getSheetCount(); //. シート数を取得
  echo "<br/>";

  $excel->setActiveSheetIndex(0);
//  $excel->getActiveSheet()->getDefaultStyle()->getFont()->setName(mb_convert_encoding('ＭＳ ゴシック','cp932'));
//  $excel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(11);


  //. Formulaを計算する指定でアクティブシートの内容を取得する
  $obj1 = $excel->getActiveSheet()->toArray( null, true, true, true );
  var_dump($obj1);
  echo "<br/>";

  //. Formulaを計算しない（式を式のままにする）指定でアクティブシートの内容を取得する
  $obj2 = $excel->getActiveSheet()->toArray( null, false, true, true );
  var_dump($obj2);
  echo "<br/>";
  
  //. 
  echo $excel->getActiveSheet()->getCell('A6')->getValue();
  echo "<br/>";

  $excel->getActiveSheet()->setCellValue('C8','123-456-789');
  $excel->getActiveSheet()->setCellValue('C10','abcd');
  $excel->getActiveSheet()->setCellValue('C12',mb_convert_encoding('こんにちは', 'UTF-8', 'UTF-8'));
//  $excel->getActiveSheet()->setCellValue('C12','こんにちは');
  echo date('H:i:s') . " データを書き込みます。特殊文字も試してみます<br>\n";
  echo "書き込み終了";
  echo "<br/>";

  // Excel2007形式(xlsx)で出力する
  $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
  $writer->save( $excelfilepath );

}else{
  echo "No reader.";
}
?>

</BODY>
</HTML>