<?php
//. PHPExcel ���C�u�����̓ǂݍ���
include_once( dirname( __FILE__ ) . '/Classes/PHPExcel.php' );
include_once( dirname( __FILE__ ) . '/Classes/PHPExcel/IOFactory.php' );

//. endsWith �֐��̒�`
function endsWith( $str, $suffix ){
  $len = strlen( $suffix );
  return $len == 0 || substr( $str, strlen( $str ) - $len, $len ) === $suffix;
}

//. �Ώۃt�@�C����
$excelfilename = 'Book1.xls';
$excelfilepath = dirname( __FILE__ ) . '/' . $excelfilename;

//. �t�@�C���g���q�ɂ���ă��[�_�[�C���X�^���X��ς���
$reader = null;
if( endsWith( $excelfilename, 'xls' ) ){
  $reader = PHPExcel_IOFactory::createReader( 'Excel5' );
}else if( endsWith( $excelfilename, 'xlsx' ) ){
  $reader = PHPExcel_IOFactory::createReader( 'Excel2007' );
}

if( $reader ){
  //. �G�N�Z���t�@�C����ǂݍ���
  $excel = $reader->load( $excelfilepath );
  echo $excel->getSheetCount(); //. �V�[�g�����擾
  echo "<br/>";

  //. Formula���v�Z����w��ŃA�N�e�B�u�V�[�g�̓��e���擾����
  $obj1 = $excel->getActiveSheet()->toArray( null, true, true, true );
  var_dump($obj1);
  echo "<br/>";

  //. Formula���v�Z���Ȃ��i�������̂܂܂ɂ���j�w��ŃA�N�e�B�u�V�[�g�̓��e���擾����
  $obj2 = $excel->getActiveSheet()->toArray( null, false, true, true );
  var_dump($obj2);
  echo "<br/>";
}else{
  echo "No reader.";
}
?>