<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
</HEAD>
<BODY>
<?php
date_default_timezone_set('Asia/Tokyo');
include_once( dirname( __FILE__ ) . '/Classes/PHPExcel/autoloader.php');

$book = new PHPExcel();
$book->getProperties()
    ->setCreator("�c�� ���Y")
    ->setLastModifiedBy("�R�c �Ԏq")
    ->setCompany('������Ё���')
    ->setCreated(strtotime('2016-01-02 03:04:05'))
    ->setModified(strtotime('2016-02-03 04:05:06'))
    ->setManager('���� ���Y')
    ->setTitle("�^�C�g��")
    ->setSubject("�T�u�W�F�N�g")
    ->setDescription("������")
    ->setKeywords("�G�N�Z�� PHP �o��")
    ->setCategory("PHP������");

$writer = PHPExcel_IOFactory::createWriter($book, 'Excel2007');
$writer->save('/Data/01-test.xlsx');
?>
</BODY>
</HTML>