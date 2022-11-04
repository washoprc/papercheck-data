<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(管理3)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>

<BODY>

<?php
// PhpSpreadsheet ライブラリー
require_once "phpspreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

// Fpdf ライブラリー
require_once "Fpdf/mbfpdf.php";
  
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

//  var_dump($_GET);

$_fromNo = $_GET['fn'];
$_staffOnly = $_GET['so'];
$cRow = $_GET['cr'];

$backDisplay = $_GET['bD'];
$statusCodeShow = $_GET['sCS'];
$fiscalYear = $_GET['fy'];
$suggestion = $_GET['sg'];

$excelfilename = 'EntrySheet.xlsx';
$excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
$reader = new XlsxReader;
$excel = $reader->load($excelfilepath);

$ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
$ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)

/*
$obj1 = $ws1->toArray( null, true, true, true );
var_dump($obj1);
echo "<br/>";
$obj2 = $ws2->toArray( null, true, true, true );
var_dump($obj2);
echo "<br/>";
*/
  
  if (empty($cRow)) {
    $_fromNo++;
    $entryNo = "";
    $_msg = "location: ../_selector.php?fn=".$_fromNo."&so=".$_staffOnly."&en=".$entryNo;
    
    header($_msg);
    exit;
  }
  
  
  
  $entryNo = mb_convert_encoding($ws2->getCell('B'.$cRow)->getValue(), 'SJIS', 'auto');
  $entryDate = mb_convert_encoding($ws2->getCell('AB'.$cRow)->getValue(), 'SJIS', 'auto');
  $requester = mb_convert_encoding($ws2->getCell('C'.$cRow)->getValue(), 'SJIS', 'auto');
  $requesterEmail = mb_convert_encoding($ws2->getCell('D'.$cRow)->getValue(), 'SJIS', 'auto');
  $eventTitle = mb_convert_encoding($ws2->getCell('E'.$cRow)->getValue(), 'SJIS', 'auto');
  $author = mb_convert_encoding($ws2->getCell('F'.$cRow)->getValue(), 'SJIS', 'auto');
  $meetingTitle = mb_convert_encoding($ws2->getCell('G'.$cRow)->getValue(), 'SJIS', 'auto');
  $meetingDate = mb_convert_encoding($ws2->getCell('H'.$cRow)->getValue(), 'SJIS', 'auto');
  $abstract = mb_convert_encoding($ws2->getCell('I'.$cRow)->getValue(), 'SJIS', 'auto');
  $attachment = $ws2->getCell('J'.$cRow)->getValue();
  $meetingDateTo = mb_convert_encoding($ws2->getCell('K'.$cRow)->getValue(), 'SJIS', 'auto');
  $reviewerJname = mb_convert_encoding($ws2->getCell('O'.$cRow)->getValue(), 'SJIS', 'auto');
  $comment1 = mb_convert_encoding($ws2->getCell('R'.$cRow)->getValue(), 'SJIS', 'auto');
  $comment2 = mb_convert_encoding($ws2->getCell('S'.$cRow)->getValue(), 'SJIS', 'auto');
  $decision = mb_convert_encoding($ws2->getCell('V'.$cRow)->getValue(), 'SJIS', 'auto');
  $closeNote = mb_convert_encoding($ws2->getCell('W'.$cRow)->getValue(), 'SJIS', 'auto');
  $statusTime32 = mb_convert_encoding($ws2->getCell('AD'.$cRow)->getValue(), 'SJIS', 'auto');
  $statusTime34 = mb_convert_encoding($ws2->getCell('AI'.$cRow)->getValue(), 'SJIS', 'auto');
  $statusTime42 = mb_convert_encoding($ws2->getCell('AE'.$cRow)->getValue(), 'SJIS', 'auto');
  

  
  $pdf=new MBFPDF('P', 'mm', 'A4');                          // MBFPDF(orientation, unit, format)
  $pdf->SetTitle(mb_convert_encoding('外部発表審査', 'SJIS', 'auto'));
  $pdf->SetAuthor('Plasma Research Center');
  $pdf->SetCreator('FPDF Appli');
  
  $pdf->AddMBFont(PGOTHIC,'SJIS');                           // AddMBFont(family, enc)
  $pdf->SetMargins(18.0, 4.0, 10.0);                         // SetMargins(left, top, right)
  $pdf->AddPage();
  
  
  $x0 = $pdf->GetX();
  $y0 = $pdf->GetY();
  $pdf->SetXY($x0,$y0);
  $pdf->SetFont(PGOTHIC,'',20);                              // SetFont(family, style, size)
  $pdf->Cell(0,15,mb_convert_encoding('外部発表審査申請', 'SJIS', 'auto'), 0, 0, 'C');            // Cell(w, h, txt, border, ln, align, fill, link)
  
  
  
  switch ((int)$_fromNo) {
    
    case 50:
    case 5:
      // 差戻し時の申請情報のみのPDF
      
      $pdf->SetFontSize(10);
      $pdf->SetFillColor(224);                               // SetFillColor(r, g, b)
      $pdf->SetXY($x0,$y0+15);
      $x1 = 40;
      $h1 = 6;
      
      $pdf->Cell($x1, 10, mb_convert_encoding(' 申請番号', 'SJIS', 'auto'), 'LTRB', 0, 'L', true);
      $pdf->Cell(0, 10, $entryNo, 'TRB', 1);
      $pdf->Cell($x1, 10, mb_convert_encoding(' 申請日', 'SJIS', 'auto'), 'LTRB', 0, 'L', true);
      $pdf->Cell(0, 10, $entryDate, 'TRB', 1);
      $pdf->Ln(2);
      
      $pdf->Cell($x1, 10, mb_convert_encoding(' 申請者氏名', 'SJIS', 'auto'), 'LTRB', 0, 'L', true);
      $pdf->Cell(0, 10, $requester, 'TRB', 1);
      $pdf->Cell($x1, 10, mb_convert_encoding('  メールアドレス', 'SJIS', 'auto'), 'LTRB', 0, 'L', true);
      $pdf->Cell(0, 10, $requesterEmail, 'TRB', 1);
      
      if (onlyHankaku($eventTitle)) {
        $limit_no = 88;
        $limit_no2 = 88;
        $str = str_split($eventTitle, $limit_no);
      } else {
        $limit_no = 56;
        $limit_no2 = 80;
        $str = mb_str_split($eventTitle, $limit_no);
      }
      $pdf->Cell($x1, $h1, '', 'LTR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[0],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 題目', 'SJIS', 'auto'), 'LR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[1],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'RB', 1);
      
      if (onlyHankaku($author)) {
        $limit_no = 88;
        $limit_no2 = 88;
        $str = str_split($author, $limit_no);
      } else {
        $limit_no = 56;
        $limit_no2 = 80;
        $str = mb_str_split($author, $limit_no);
      }
      $pdf->Cell($x1, $h1, '', 'LTR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[0],0,$limit_no2,'',SJIS), 'TR', 1);
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 著者', 'SJIS', 'auto'), 'LR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[1],0,$limit_no2,'',SJIS), 'R', 1);
      if (empty($str[3])) {
        $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'RB', 1);    
      } else {
        $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'R', 1);
        $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[3],0,$limit_no2,'',SJIS), 'RB', 1);
      }
      
      if (onlyHankaku($meetingTitle)) {
        $limit_no = 88;
        $limit_no2 = 88;
        $str = str_split($meetingTitle, $limit_no);
      } else {
        $limit_no = 56;
        $limit_no2 = 80;
        $str = mb_str_split($meetingTitle, $limit_no);
      }
      $pdf->Cell($x1, $h1, '', 'LTR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[0],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 学術誌/会議名 等', 'SJIS', 'auto'), 'LR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[1],0,$limit_no2,'',SJIS), 'R', 1);
      if (empty($str[3])) {
        $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'RB', 1);    
      } else {
        $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'R', 1);
        $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[3],0,$limit_no2,'',SJIS), 'RB', 1);
      }
      
      $pdf->Cell($x1, 10, mb_convert_encoding(' 会議開催期間', 'SJIS', 'auto'), 'LTRB', 0, 'L', true);
      $str = "from ".$meetingDate."  to ".$meetingDateTo;
      $pdf->Cell(0, 10, $str, 'RB', 1);
      
      if (onlyHankaku($abstract)) {
        $limit_no = 88;
        $limit_no2 = 88;
        $str = str_split($abstract, $limit_no);
      } else {
        $limit_no = 56;
        $limit_no2 = 80;
        $str = mb_str_split($abstract, $limit_no);
      }
      $pdf->Cell($x1, $h1, '', 'LTR', 0, 'L', true);
// echo "[0]=(".mb_convert_encoding($str[0], 'utf8', 'auto').")<br>";
      $pdf->Cell(0, $h1, mb_strimwidth($str[0],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
// echo "[1]=(".mb_convert_encoding($str[1], 'utf8', 'auto').")<br>";
      $pdf->Cell(0, $h1, mb_strimwidth($str[1],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
// echo "[2]=(".mb_convert_encoding($str[2], 'utf8', 'auto').")<br>";
      $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 論文の要点', 'SJIS', 'auto'), 'LR', 0, 'L', true);
// echo "[3]=(".mb_convert_encoding($str[3], 'utf8', 'auto').")<br>";
      $pdf->Cell(0, $h1, mb_strimwidth($str[3],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
// echo "[4]=(".mb_convert_encoding($str[4], 'utf8', 'auto').")<br>";
      $pdf->Cell(0, $h1, mb_strimwidth($str[4],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[5],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[6],0,$limit_no2,'',SJIS), 'R', 1);
      if (empty($str[8])) {
        $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[7],0,$limit_no2,'',SJIS), 'RB', 1);
      } else {
        if (empty($str[9])) {
          $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[7],0,$limit_no2,'',SJIS), 'R', 1);
          $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[8],0,$limit_no2,'',SJIS), 'RB', 1);
        } else {
          if (empty($str[10])) {
            $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
            $pdf->Cell(0, $h1, mb_strimwidth($str[7],0,$limit_no2,'',SJIS), 'R', 1);
            $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
            $pdf->Cell(0, $h1, mb_strimwidth($str[8],0,$limit_no2,'',SJIS), 'R', 1);
            $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
            $pdf->Cell(0, $h1, mb_strimwidth($str[9],0,$limit_no2,'',SJIS), 'RB', 1);
          } else {
            $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
            $pdf->Cell(0, $h1, mb_strimwidth($str[7],0,$limit_no2,'',SJIS), 'R', 1);
            $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
            $pdf->Cell(0, $h1, mb_strimwidth($str[8],0,$limit_no2,'',SJIS), 'R', 1);
            $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
            $pdf->Cell(0, $h1, mb_strimwidth($str[9],0,$limit_no2,'',SJIS), 'R', 1);
            $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
            $pdf->Cell(0, $h1, mb_strimwidth($str[10],0,$limit_no2,'',SJIS), 'RB', 1);
          }
        }
      }
      
      $pdf->Ln(5);                                           // Ln(h)
      
      $pdf->SetFontSize(12);
      $pdf->SetTextColor(220, 20, 60);                       // SetTextColor(r, g, b)
      $pdf->Write(10, mb_convert_encoding('この申請は幹事により差戻しとなっています。', 'SJIS', 'auto'));
      $pdf->SetTextColor(0, 0, 0);
      
      $file_pdf = "./tmp/entry.pdf";
  //*    $pdf->Output($file_pdf,'F');                           // Output(name, dest)
      
// echo date('H:i:s')."  差戻し用 PDF作成終了<br>";
      
      break;
      
      
      
    case 40:
    case 4:
      // 処理が終了した申請を保存用としてPDF作成する
      
      $pdf->SetFontSize(10);
      $pdf->SetFillColor(224);                               // SetFillColor(r, g, b)
      $pdf->SetXY($x0,$y0+15);
      $x1 = 40;
      $h1 = 6;
      
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 申請番号', 'SJIS', 'auto'), 'LTRB', 0, 'L', true);
      $pdf->Cell(0, $h1, $entryNo, 'TRB', 1);
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 申請日', 'SJIS', 'auto'), 'LTRB', 0, 'L', true);
      $pdf->Cell(0, $h1, $entryDate, 'TRB', 1);
      $pdf->Ln(2);
      
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 申請者氏名', 'SJIS', 'auto'), 'LTRB', 0, 'L', true);
      $pdf->Cell(0, $h1, $requester, 'TRB', 1);
      $pdf->Cell($x1, $h1, mb_convert_encoding('  メールアドレス', 'SJIS', 'auto'), 'LTRB', 0, 'L', true);
      $pdf->Cell(0, $h1, $requesterEmail, 'TRB', 1);
      
      if (onlyHankaku($eventTitle)) {
        $limit_no = 88;
        $limit_no2 = 88;
        $str = str_split($eventTitle, $limit_no);
      } else {
        $limit_no = 56;
        $limit_no2 = 80;
        $str = mb_str_split($eventTitle, $limit_no);
      }
      $pdf->Cell($x1, $h1, '', 'LTR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[0],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 題目', 'SJIS', 'auto'), 'LR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[1],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'RB', 1);
      
      if (onlyHankaku($author)) {
        $limit_no = 88;
        $limit_no2 = 88;
        $str = str_split($author, $limit_no);
      } else {
        $limit_no = 56;
        $limit_no2 = 80;
        $str = mb_str_split($author, $limit_no);
      }
      $pdf->Cell($x1, $h1, '', 'LTR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[0],0,$limit_no2,'',SJIS), 'TR', 1);
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 著者', 'SJIS', 'auto'), 'LR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[1],0,$limit_no2,'',SJIS), 'R', 1);
      if (empty($str[3])) {
        $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'RB', 1);    
      } else {
        $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'R', 1);
        $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[3],0,$limit_no2,'',SJIS), 'RB', 1);
      }
      
      if (onlyHankaku($meetingTitle)) {
        $limit_no = 88;
        $limit_no2 = 88;
        $str = str_split($meetingTitle, $limit_no);
      } else {
        $limit_no = 56;
        $limit_no2 = 80;
        $str = mb_str_split($meetingTitle, $limit_no);
      }
      $pdf->Cell($x1, $h1, '', 'LTR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[0],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 学術誌/会議名 等', 'SJIS', 'auto'), 'LR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[1],0,$limit_no2,'',SJIS), 'R', 1);
      if (empty($str[3])) {
        $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'RB', 1);    
      } else {
        $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'R', 1);
        $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[3],0,$limit_no2,'',SJIS), 'RB', 1);
      }
      
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 会議開催期間', 'SJIS', 'auto'), 'LTRB', 0, 'L', true);
      $str = "from ".$meetingDate."  to ".$meetingDateTo;
      $pdf->Cell(0, $h1, $str, 'RB', 1);
      
      if (onlyHankaku($abstract)) {
        $limit_no = 88;
        $limit_no2 = 88;
        $str = str_split($abstract, $limit_no);
      } else {
        $limit_no = 56;
        $limit_no2 = 80;
        $str = mb_str_split($abstract, $limit_no);
      }
      $pdf->Cell($x1, $h1, '', 'LTR', 0, 'L', true);
// echo "[0]=(".mb_convert_encoding($str[0], 'utf8', 'auto').")<br>";
      $pdf->Cell(0, $h1, mb_strimwidth($str[0],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
// echo "[1]=(".mb_convert_encoding($str[1], 'utf8', 'auto').")<br>";
      $pdf->Cell(0, $h1, mb_strimwidth($str[1],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
// echo "[2]=(".mb_convert_encoding($str[2], 'utf8', 'auto').")<br>";
      $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 論文の要点', 'SJIS', 'auto'), 'LR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[3],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[4],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[5],0,$limit_no2,'',SJIS), 'R', 1);
      $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[6],0,$limit_no2,'',SJIS), 'R', 1);
      if (empty($str[8])) {
        $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[7],0,$limit_no2,'',SJIS), 'RB', 1);
      } else {
        if (empty($str[9])) {
          $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[7],0,$limit_no2,'',SJIS), 'R', 1);
          $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[8],0,$limit_no2,'',SJIS), 'RB', 1);
        } else {
          if (empty($str[10])) {
            $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
            $pdf->Cell(0, $h1, mb_strimwidth($str[7],0,$limit_no2,'',SJIS), 'R', 1);
            $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
            $pdf->Cell(0, $h1, mb_strimwidth($str[8],0,$limit_no2,'',SJIS), 'R', 1);
            $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
            $pdf->Cell(0, $h1, mb_strimwidth($str[9],0,$limit_no2,'',SJIS), 'RB', 1);
          } else {
            $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
            $pdf->Cell(0, $h1, mb_strimwidth($str[7],0,$limit_no2,'',SJIS), 'R', 1);
            $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
            $pdf->Cell(0, $h1, mb_strimwidth($str[8],0,$limit_no2,'',SJIS), 'R', 1);
            $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
            $pdf->Cell(0, $h1, mb_strimwidth($str[9],0,$limit_no2,'',SJIS), 'R', 1);
            $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
            $pdf->Cell(0, $h1, mb_strimwidth($str[10],0,$limit_no2,'',SJIS), 'RB', 1);
          }
        }
      }
      $pdf->Ln(2);
      
      
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 審査者', 'SJIS', 'auto'), 'LTRB', 0, 'L', true);
      $pdf->Cell(0, $h1, $reviewerJname, 'TRB', 1);
      $pdf->Ln(1);
      
      
      $limit_no = 56;
      $limit_no2 = 80;
      $str = mb_str_split($comment1, $limit_no);
      $pdf->Cell($x1, $h1, mb_convert_encoding(' コメント１', 'SJIS', 'auto'), 'LTR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[0],0,$limit_no2,'',SJIS), 'TR', 1);
      $pdf->Cell($x1, $h1, mb_convert_encoding('  (アブストラクト等', 'SJIS', 'auto'), 'LR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[1],0,$limit_no2,'',SJIS), 'R', 1);
      if (empty($str[3])) {
        $pdf->Cell($x1, $h1, mb_convert_encoding('        について)', 'SJIS', 'auto'), 'LRB', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'RB', 1);
      } else {
        if (empty($str[4])) {
          $pdf->Cell($x1, $h1, mb_convert_encoding('        について)', 'SJIS', 'auto'), 'LR', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'R', 1);
          $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[3],0,$limit_no2,'',SJIS), 'RB', 1);
        } else {
          $pdf->Cell($x1, $h1, mb_convert_encoding('        について)', 'SJIS', 'auto'), 'LR', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'R', 1);
          $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[3],0,$limit_no2,'',SJIS), 'R', 1);
          $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[4],0,$limit_no2,'',SJIS), 'RB', 1);
        }
      }
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 審査日', 'SJIS', 'auto'), 'LTRB', 0, 'L', true);
      $pdf->Cell(0, $h1, $statusTime32, 'RB', 1);
      $pdf->Ln(1);
      
      
      $limit_no = 56;
      $limit_no2 = 80;
      $str = mb_str_split($comment2, $limit_no);
      $pdf->Cell($x1, $h1, mb_convert_encoding(' コメント２', 'SJIS', 'auto'), 'LTR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[0],0,$limit_no2,'',SJIS), 'TR', 1);
      $pdf->Cell($x1, $h1, mb_convert_encoding('  (本論文等について)', 'SJIS', 'auto'), 'LR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[1],0,$limit_no2,'',SJIS), 'R', 1);
      if (empty($str[3])) {
        $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'RB', 1);
      } else {
        if (empty($str[4])) {
          $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'R', 1);
          $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[3],0,$limit_no2,'',SJIS), 'RB', 1);
        } else {
          $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'R', 1);
          $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[3],0,$limit_no2,'',SJIS), 'R', 1);
          $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[4],0,$limit_no2,'',SJIS), 'RB', 1);
        }
      }
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 審査日', 'SJIS', 'auto'), 'LTRB', 0, 'L', true);
      $pdf->Cell(0, $h1, $statusTime34, 'RB', 1);
      $pdf->Ln(2);
      
      
      if (onlyHankaku($closeNote)) {
        $limit_no = 88;
        $limit_no2 = 88;
        $str = str_split($closeNote, $limit_no);
      } else {
        $limit_no = 56;
        $limit_no2 = 80;
        $str = mb_str_split($closeNote, $limit_no);
      }
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 委員会からの', 'SJIS', 'auto'), 'LTR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[0],0,$limit_no2,'',SJIS), 'TR', 1);
      $pdf->Cell($x1, $h1, mb_convert_encoding('  コメント/特記など', 'SJIS', 'auto'), 'LR', 0, 'L', true);
      $pdf->Cell(0, $h1, mb_strimwidth($str[1],0,$limit_no2,'',SJIS), 'R', 1);
      if (empty($str[3])) {
        $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
        $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'RB', 1);
      } else {
        if (empty($str[4])) {
          $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'R', 1);
          $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[3],0,$limit_no2,'',SJIS), 'RB', 1);
        } else {
          $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[2],0,$limit_no2,'',SJIS), 'R', 1);
          $pdf->Cell($x1, $h1, '', 'LR', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[3],0,$limit_no2,'',SJIS), 'R', 1);
          $pdf->Cell($x1, $h1, '', 'LRB', 0, 'L', true);
          $pdf->Cell(0, $h1, mb_strimwidth($str[4],0,$limit_no2,'',SJIS), 'RB', 1);
        }
      }
      
      $pdf->Cell($x1, $h1, mb_convert_encoding(' 判定日', 'SJIS', 'auto'), 'LTRB', 0, 'L', true);
      $pdf->Cell(0, $h1, $statusTime42, 'RB', 1);
      
      $file_pdf = "./entry_pdf/" . $entryNo . ".pdf";
  //*    $pdf->Output($file_pdf,'F');
      
// echo date('H:i:s')."  保存用 PDF作成終了<br>";
      
      break;
      
    default:
      
  }
  
  
  
function onlyHankaku($data) {
  $toEncoding = 'UTF-8';
  $encoding = mb_internal_encoding();
  
  $str = mb_convert_encoding($data, $toEncoding, $encoding);
  
  if (strlen($str) === mb_strlen($str, $toEncoding)) {
    // 半角
    return true;
  } else {
    // 全角
    return false;
  }
}

function mb_str_split($str, $split_len) {
  $toEncoding = 'UTF-8';
  mb_internal_encoding('UTF-8');
  mb_regex_encoding('UTF-8');
  
  if ($split_len <= 0) {
    $split_len = 1;
  }
  
  $strlen = mb_strlen($str, $toEncoding);
  $ret    = array();
  
  for ($i = 0; $i < $strlen; $i += $split_len) {
      $ret[ ] = mb_substr($str, $i, $split_len, $toEncoding);
  }
  return $ret;
}
  
  
  
  switch ((int)$_fromNo) {
    case 4:
      $_msg = "location: ./_closeSteps.php?fn=".$_fromNo."&so=".$_staffOnly."&cr=".$cRow."&bD=".$backDisplay."&sCS=".$statusCodeShow."&fy=".$fiscalYear;
      break;
      
    case 5:
      $_msg = "location: ./_remandForm.php?fn=".$_fromNo."&so=".$_staffOnly."&cr=".$cRow."&sg=".$suggestion."&bD=".$backDisplay;
      break;
      
    case 40:
    case 50:
      $_msg = "location: ../_selector.php?fn=".$_fromNo."&so=".$_staffOnly."&en=".$entryNo;
      break;
      
    default:
      $_fromNo = 9;
      $_msg = "location: ../_selector.php?fn=".$_fromNo."&so=".$_staffOnly."&en=".$entryNo;
      
  }
  
  header($_msg);
  exit;

?>


<BR>　この処理(_createPDF)は終了しました<BR>
<BR>　　申請番号: <?php echo $entryNo ?> です<BR>
<BR>
<FORM>
  <?php
  if ($_staffOnly) {
    $_msg = "　管理に戻る　";
    $_codename = "location.href='./staff_only.php'";
  } else {
    $_msg = "　ホームに戻る　";
    $_codename = "location.href='http://www.prc.tsukuba.ac.jp/papercheck/'";
  }
  ?>
  <INPUT type="button" name="" value="<?php echo $_msg ?>" onclick="<?php echo $_codename ?>">
</FORM>
<BR>

</BODY>
</HTML>
