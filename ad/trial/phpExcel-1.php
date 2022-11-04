<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
</HEAD>
<BODY>
<?php
	//PHPExcelファイルの読み込み
    include_once ( __DIR__ . '/Classes/PHPExcel.php');
    include_once ( __DIR__ . '/Classes/PHPExcel/IOFactory.php');
//    include './Classes/PHPExcel.php';
//    include './Classes/PHPExcel/IOFactory.php';

echo " on the way #1\n";
	//エクセルファイルの新規作成
    $excel = new PHPExcel();

echo " 途中２\n";
	// シートの設定
    $excel->setActiveSheetIndex(0);//何番目のシートか
    $sheet = $excel->getActiveSheet();//有効になっているシートを代入

echo " on the way #3\n";
	// セルに値を入力
    $sheet->setCellValue('A1', 'こんにちは！');//A1のセルにこんにちは！という値を入力
 
echo " on the way #4\n";
	// Excel2007形式で出力する
    $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
echo " on the way #5\n";
    $writer->save("output.xlsx");

echo " finish #6\n";
?>
</BODY>
</HTML>