<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>
<?php


// mb_language("Japanese");
// mb_internal_encoding("SJIS");

// mb_internal_encoding("UTF-8");


//. PHPExcel ���C�u�����̓ǂݍ���
include_once( dirname( __FILE__ ) . '/Classes/PHPExcel.php' );
include_once( dirname( __FILE__ ) . '/Classes/PHPExcel/IOFactory.php' );

//. endsWith �֐��̒�`
function endsWith( $str, $suffix ){
  $len = strlen( $suffix );
  return $len == 0 || substr( $str, strlen( $str ) - $len, $len ) === $suffix;
}

//. �Ώۃt�@�C����
$excelfilename = 'Book1.xlsx';
$excelfilepath = dirname( __FILE__ ) . '/Data/' . $excelfilename;

//. �t�@�C���g���q�ɂ���ă��[�_�[�C���X�^���X��ς���
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
  //. �G�N�Z���t�@�C����ǂݍ���
  $excel = $reader->load( $excelfilepath );
  echo $excel->getSheetCount(); //. �V�[�g�����擾
  echo "<br/>";

  $excel->setActiveSheetIndex(0);
//  $excel->getActiveSheet()->getDefaultStyle()->getFont()->setName(mb_convert_encoding('�l�r �S�V�b�N','cp932'));
//  $excel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(11);


  //. Formula���v�Z����w��ŃA�N�e�B�u�V�[�g�̓��e���擾����
  $obj1 = $excel->getActiveSheet()->toArray( null, true, true, true );
  var_dump($obj1);
  echo "<br/>";

  //. Formula���v�Z���Ȃ��i�������̂܂܂ɂ���j�w��ŃA�N�e�B�u�V�[�g�̓��e���擾����
  $obj2 = $excel->getActiveSheet()->toArray( null, false, true, true );
  var_dump($obj2);
  echo "<br/>";
  
  //. 
  echo $excel->getActiveSheet()->getCell('A6')->getValue();
  echo "<br/>";

  $excel->getActiveSheet()->setCellValue('C8','123-456-789');
  $excel->getActiveSheet()->setCellValue('C10','abcd');
  $excel->getActiveSheet()->setCellValue('C12',mb_convert_encoding('����ɂ���', 'UTF-8', 'UTF-8'));
//  $excel->getActiveSheet()->setCellValue('C12','����ɂ���');
  echo date('H:i:s') . " �f�[�^���������݂܂��B���ꕶ���������Ă݂܂�<br>\n";
  echo "�������ݏI��";
  echo "<br/>";

  // Excel2007�`��(xlsx)�ŏo�͂���
  $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
  $writer->save( $excelfilepath );

}else{
  echo "No reader.";
}
?>

</BODY>
</HTML>