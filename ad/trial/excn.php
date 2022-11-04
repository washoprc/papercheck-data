<?php
// 文字コードセット
mb_language("Japanese");
mb_internal_encoding("UTF-8");

require('../fpdf/mbfpdf.php');

$pdf=new MBFPDF();
$pdf->AddMBFont(BIG5,'BIG5');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont(BIG5,'',20);
$pdf->Write(10,'ｲ{ｮﾉｮﾅ 18 C ﾀ罩ﾗ 83 %');
$pdf->Output();
?>
