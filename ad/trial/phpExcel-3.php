<?php
//. PHPExcel ライブラリの読み込み
include_once( dirname( __FILE__ ) . '/Classes/PHPExcel.php' );
include_once( dirname( __FILE__ ) . '/Classes/PHPExcel/IOFactory.php' );

//. endsWith 関数の定義
function endsWith( $str, $suffix ){
  $len = strlen( $suffix );
  return $len == 0 || substr( $str, strlen( $str ) - $len, $len ) === $suffix;
}

//. 対象ファイル名
$excelfilename = 'Book1.xls';
$excelfilepath = dirname( __FILE__ ) . '/' . $excelfilename;

//. ファイル拡張子によってリーダーインスタンスを変える
$reader = null;
if( endsWith( $excelfilename, 'xls' ) ){
  $reader = PHPExcel_IOFactory::createReader( 'Excel5' );
}else if( endsWith( $excelfilename, 'xlsx' ) ){
  $reader = PHPExcel_IOFactory::createReader( 'Excel2007' );
}

if( $reader ){
  //. エクセルファイルを読み込む
  $excel = $reader->load( $excelfilepath );
  echo $excel->getSheetCount(); //. シート数を取得
  echo "<br/>";

  //. Formulaを計算する指定でアクティブシートの内容を取得する
  $obj1 = $excel->getActiveSheet()->toArray( null, true, true, true );
  var_dump($obj1);
  echo "<br/>";

  //. Formulaを計算しない（式を式のままにする）指定でアクティブシートの内容を取得する
  $obj2 = $excel->getActiveSheet()->toArray( null, false, true, true );
  var_dump($obj2);
  echo "<br/>";
}else{
  echo "No reader.";
}
?>