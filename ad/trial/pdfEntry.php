
<?php
require('../fpdf/mbfpdf.php');

$pdf=new MBFPDF('P', 'mm', 'A4');
$pdf->AddMBFont(PGOTHIC,'SJIS');
$pdf->AddPage();

$pdf->SetXY(100,20);
$pdf->SetFont(PGOTHIC,'',24);
$pdf->Write(10,"外部発表審査申請\n");

$pdf->SetXY(10,40);
$x = $pdf->GetX();
$pdf->Cell(0, 15, '境界線を上下左右、横幅は右端まで', 1, 1);
$pdf->SetXY($x,55);
$pdf->Cell(40, 15, '申請者氏名', 1);
$pdf->Cell(100, 15, '岡崎　昇', 1, 1);

// $pdf->Output('doc.pdf','I');
$pdf->Output();

?>
