
<?php
require('../fpdf/mbfpdf.php');

$pdf=new MBFPDF('P', 'mm', 'A4');
$pdf->AddMBFont(PGOTHIC,'SJIS');
$pdf->AddPage();

$pdf->SetXY(100,20);
$pdf->SetFont(PGOTHIC,'',24);
$pdf->Write(10,"�O�����\�R���\��\n");

$pdf->SetXY(10,40);
$x = $pdf->GetX();
$pdf->Cell(0, 15, '���E�����㉺���E�A�����͉E�[�܂�', 1, 1);
$pdf->SetXY($x,55);
$pdf->Cell(40, 15, '�\���Ҏ���', 1);
$pdf->Cell(100, 15, '����@��', 1, 1);

// $pdf->Output('doc.pdf','I');
$pdf->Output();

?>
