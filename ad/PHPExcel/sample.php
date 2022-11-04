<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Shift_JIS\">
<TITLE>PRC_外部発表審査(受付1)</TITLE>
</HEAD>
<BODY>


<?php

//PHPExcelの読み込み
require_once("./Classes/PHPExcel.php");
 
$obj_excel = new PHPExcel();
 
//Excel2007形式(xlsx)のライターを作成
$writer = PHPExcel_IOFactory::createWriter($obj_excel, "Excel2007");
 
//ファイル出力
$writer->save('test.xlsx');

echo "完了";

?>

</BODY>
</HTML>
