<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<TITLE>PRC_外部発表審査(管理)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>
<BODY>

<?php
// PhpSpreadsheet ライブラリー
require_once "phpspreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

//  var_dump($_GET);
//  var_dump($_POST);

include_once( dirname( __FILE__ ) . '/../functions.php' );

$chk_st42 = $_POST['chk_st42'];
$_staffOnly_g = $_GET['so'];
$_staffOnly_p = $_POST['so'];
$fiscalYear_g = $_GET['fy'];
$fiscalYear_p = $_POST['FiscalYear'];
$OrderDisplay = $_GET['od'];
$backDisplay = (int)$_GET['bD'];

if (isset($_staffOnly_g))
  $_staffOnly = $_staffOnly_g;
else
  if (isset($_staffOnly_p))
    $_staffOnly = $_staffOnly_p;
  else
    $_staffOnly = 0;

if (empty($fiscalYear_g) && empty($fiscalYear_p)) {
  $fiscalYear = getThisFiscal('Y');
} else if (empty($fiscalYear_g)) {
  $fiscalYear = intval($fiscalYear_p);
} else {
  $fiscalYear = intval($fiscalYear_g);
}

if (!isset($OrderDisplay))
  $OrderDisplay = "B2";                       // 既定画面は会議日の降順    {A:申請日 | B:会議日}、 {1:ASC | 2:DESC}
else {
  switch (strtoupper($OrderDisplay)) {
    case "A1":
    case "A2":
    case "B1":
    case "B2":
      break;
    default:
      $OrderDisplay = "A2";
  }
}
  
  $excelfilename = 'EntrySheet.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
  $reader = new XlsxReader;
  $excel = $reader->load($excelfilepath);
  $writer = new Xlsx($excel);
  
  $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
  $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
  
  $sRow = intval($ws1->getCell('B2')->getValue());
  $eRow = intval($ws1->getCell('B3')->getValue());
  
  
  if ($chk_st42) {
    $excelfilename2 = 'template-st42.xlsx';
    $excelfilename3 = $fiscalYear . 'c-st42.xlsx';
  } else {
    $excelfilename2 = 'template.xlsx';
    $excelfilename3 = $fiscalYear . 'c.xlsx';
  }
  $excelfilepath2 = dirname( __FILE__ ) . '/yearly/' . $excelfilename2;
  $excel2 = $reader->load( $excelfilepath2 );
  $ws3 = $excel2->setActiveSheetIndexByName('Entry');
  
  $excelfilepath3 = dirname( __FILE__ ) . '/yearly/' . $excelfilename3;
  $writer3 = new Xlsx($excel2);
  
  $cRow = 5;                             // Excelファイルにデータを書込む開始行番号
  
/*
$obj1 = $ws1->toArray( null, true, true, true );
var_dump($obj1);
echo "<br/>";
$obj2 = $ws2->toArray( null, true, true, true );
var_dump($obj2);
echo "<br/>";
*/

?>

<TABLE width="760" border="0" cellpadding="0" cellspacing="0" class="hpb-main">
  <TBODY>
    <TR>
      <TD>
      
      <TABLE width="613" border="0" align="center" cellpadding="0" cellspacing="0" class="hpb-lb-tb1">
        <TBODY>
        <TR>
          <TD class="hpb-lb-tb1-cell3">
            <BR>
            <BR>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-subh02">
              <TBODY>
              <TR>
                <TD class="hpb-lb-tb1-cell4">外部発表審査</TD>
                <TD class="hpb-lb-tb1-cell4" align="center">
                  <A href="../displayJpg.php"><IMG src="../img/hint.gif" alt="手続き" width="" height="" border="0"></A></TD>
                  <?php
                  $_msg = "";
                  if ($_staffOnly) {
                    $_msg = "<A href='javascript:void(0)' onclick=location.href='./staff_only.php'>";
                    $_msg .= "<FONT color='green'>* 管理 *</FONT></A>";
                  }
                  ?>
                <TD width="100" class="hpb-lb-tb1-cell4"><?php echo $_msg ?></TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD width="300">　　Fiscal Year: <B><?php echo $fiscalYear ?></B>
                  　　　<?php if ($chk_st42) echo '判定済み' ?></TD>
                <FORM method="post" action="_mailSummary.php?st42=<?php echo $chk_st42.'&bD=2&fy='.$fiscalYear ?>">
                <TD align="center"><INPUT type="submit" name ="" value="Excelファイル入手"></TD>
                <TD align="center"><INPUT type="button" value="割当実績" onclick=window.open('./tallyReviewer.php?swin=1','_sub3','resizable=yes,width=790,height=600');return false;></TD>
                </FORM>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            <?php
            if (!$chk_st42) {
              $_msg = "　　<FONT size='-2'>進捗状況: 08=資料待ち　10=申請　22=審査者設定済み　32=審査1済み　33=対応済み　34=審査2済み　42=確認済み</FONT>";
              echo $_msg;
            }
            ?>
            <TABLE width="100%" border="1" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <?php
              if (!$chk_st42) {
                $_msg = "<TR align='center'>";
                  $_msg .= "<TH width='20' rowspan='2' class='hpb-cnt-tb-cell1'>No</TH>";
                  $_msg .= "<TH width='50' rowspan='2' class='hpb-cnt-tb-cell1'>申請者</TH>";
                  $_msg .= "<TH width='45' rowspan='2' class='hpb-cnt-tb-cell1'>申請日<BR>";
                    if ($OrderDisplay=='A1')
                      $_msg .= "<FONT size='-2' color='green'>";
                    else
                      $_msg .= "<FONT size='-1' color='blue'>";
                    $_msg.= "<A href'#' onclick=location.href='./summarizeByYear.php?so=".$_staffOnly."&fy=".$fiscalYear."&od=A1'>↑</A></FONT> , ";
                    if ($OrderDisplay=='A2')
                      $_msg .= "<FONT size='-2' color='green'>";
                    else
                      $_msg .= "<FONT size='-1' color='blue'>";
                    $_msg.= "<A href'#' onclick=location.href='./summarizeByYear.php?so=".$_staffOnly."&fy=".$fiscalYear."&od=A2'>↓</A></FONT>";
                    $_msg .= "</TH>";                  
// ******                  $_msg .= "<TH width='140' rowspan='2' class='hpb-cnt-tb-cell1'>題　目</TH>";
                  $_msg .= "<TH rowspan='2' class='hpb-cnt-tb-cell1'>学術誌/会議名等</TH>";
                  $_msg .= "<TH width='55' rowspan='2' class='hpb-cnt-tb-cell1'>会議日<BR>";
                    if ($OrderDisplay=='B1')
                      $_msg .= "<FONT size='-2' color='green'>";
                    else
                      $_msg .= "<FONT size='-1' color='blue'>";
                    $_msg.= "<A href'#' onclick=location.href='./summarizeByYear.php?so=".$_staffOnly."&fy=".$fiscalYear."&od=B1'>↑</A></FONT> , ";
                    if ($OrderDisplay=='B2')
                      $_msg .= "<FONT size='-2' color='green'>";
                    else
                      $_msg .= "<FONT size='-1' color='blue'>";
                    $_msg.= "<A href'#' onclick=location.href='./summarizeByYear.php?so=".$_staffOnly."&fy=".$fiscalYear."&od=B2'>↓</A></FONT>";
                    $_msg .= "</TH>";
                  $_msg .= "<TH width='30' rowspan='2' class='hpb-cnt-tb-cell1'>審査</TH>";
                  $_msg .= "<TH colspan='7' class='hpb-cnt-tb-cell1'>進捗状況</TH>";
                $_msg .= "</TR>\n";
                $_msg .= "<TR align='center'>";
                  $_msg .= "<TD class='hpb-cnt-tb-cell1'>08</TD>";
                  $_msg .= "<TD class='hpb-cnt-tb-cell1'>10</TD>";
                  $_msg .= "<TD class='hpb-cnt-tb-cell1'>22</TD>";
                  $_msg .= "<TD class='hpb-cnt-tb-cell1'>32</TD>";
                  $_msg .= "<TD class='hpb-cnt-tb-cell1'>33</TD>";
                  $_msg .= "<TD class='hpb-cnt-tb-cell1'>34</TD>";
                  $_msg .= "<TD class='hpb-cnt-tb-cell1'>42</TD>";
                $_msg .= "</TR>\n";
              } else {
                $_msg = "<TR align='center'>";
                  $_msg .= "<TH width='25' class='hpb-cnt-tb-cell1'>No</TH>";
                  $_msg .= "<TH width='105' class='hpb-cnt-tb-cell1'>申請者</TH>";
                  $_msg .= "<TH class='hpb-cnt-tb-cell1'>題　目</TH>";
                $_msg .= "</TR>\n";
              }
              echo $_msg;
              $_header = $_msg;
              
              
              $_array_meetingDate = array();
              $_array_entryNo = array();
              $_array_row = array();
              $OrderSort = array();
              $_ii = 0;
              $_row = $sRow;
              $_entryNo = $ws2->getCell('B'.$_row)->getValue();
              $_FiscalYear_Meeting = intval($ws2->getCell('X'.$_row)->getValue());
              $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
              while (isset($_entryNo) && $_entryNo != "eol") {
                
                if (substr($_entryNo,3,1)=='0' || substr($_entryNo,3,1)=='8') {
                                                   // 通常(0)、完了(8) のみを対象にする
             // 申請番号基準
             //    if ((substr($fiscalYear,-2).'-0' == substr($_entryNo,0,4)) || (substr($fiscalYear,-2) > substr($_entryNo,0,2) && $_statuscode !== 42)) {
             // 会議日基準
                  if (($fiscalYear == $_FiscalYear_Meeting) || ($fiscalYear > $_FiscalYear_Meeting && $_statuscode !== 42)) {
                                                   // 指定年度の申請また指定年度以前の申請で未完了のものを対象にする
                    
                    $_array_meetingDate[$_row] = $ws2->getCell('H'.$_row)->getValue();
                    $_array_entryNo[$_row] = $ws2->getCell('B'.$_row)->getValue();
                    $_array_row[$_row] = $_row;
                  }
                }
                
                if ($_row >= 1000) {
                  break;
                } else {
                  $_ii++;
                  $_row++;
                  $_entryNo = $ws2->getCell('B'.$_row)->getValue();
                  $_FiscalYear_Meeting = intval($ws2->getCell('X'.$_row)->getValue());
                  $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
                }
              }
              
              
              switch (strtoupper($OrderDisplay)) {
                case "A1":
           //       ksort($_array_meetingDate);             // 行番号(申請日)で昇順にする
           //                                               //   キーと値のペアを維持しつつ配列のキーを昇順に並べ替える (連想配列が使える)
                  
                                                          // 第一条件：申請番号を昇順
                  array_multisort($_array_entryNo, SORT_ASC, $_array_row);
                  $OrderSort = $_array_row;
                  break;
                case "A2":
           //       krsort($_array_meetingDate);            // 行番号(申請日)で降順にする
                  
                                                          // 第一条件：申請番号を降順
                  array_multisort($_array_entryNo, SORT_DESC, $_array_row);
                  $OrderSort = $_array_row;
                  
                  break;
                case "B1":
           //       asort($_array_meetingDate);             // 会議日で昇順にする
           //                                               //   キーと値のペアを維持しつつ配列の要素を昇順に並べ替える
                  
                                                          // 第一条件：会議日を昇順,  第二条件：申請番号を昇順
                  array_multisort($_array_meetingDate, $_array_entryNo, $_array_row);
                  $OrderSort = $_array_row;
                  break;
                case "B2":
           //       arsort($_array_meetingDate);            // 会議日で降順にする
                  
                                                          // 第一条件：会議日を降順,  第二条件：申請番号を降順
                  array_multisort($_array_meetingDate, SORT_DESC, $_array_entryNo, SORT_DESC, $_array_row);
                  $OrderSort = $_array_row;
                  break;
                default:
                  
              }
              
              
              
              $_ii = 0;
              foreach($OrderSort as $_row) {
                
                if ($_ii % 2==0)
                  $_class = "hpb-cnt-tb-cell2-a";
                else
                  $_class = "hpb-cnt-tb-cell2-b";
                
                if (!$chk_st42) {
                  
                  $entryNo = $ws2->getCell('B'.$_row)->getValue();
                  $requester = $ws2->getCell('C'.$_row)->getValue();
                  $entryDate = $ws2->getCell('AB'.$_row)->getValue();
// ******                  $eventTitle = $ws2->getCell('E'.$_row)->getValue();
                  $meetingTitle = $ws2->getCell('G'.$_row)->getValue();
                  $meetingDate = $ws2->getCell('H'.$_row)->getValue();
                  $reviewerJname = $ws2->getCell('O'.$_row)->getValue();
                  $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
                  
                  $_msg = "<TR align='left'>";
                  $_msg .= "<TD align='right' class='".$_class."'>";
                  if ($_statuscode == 10)                              // 申請中　審査者設定の処理が必要
                    $_msg .= "<A href='#' onclick=window.open('./assignReviewer.php?id=".$entryNo."&so=".$_staffOnly."&bD=2','_sub2','resizable=yes,width=790,height=900');return false;>".(int)substr($entryNo,4)."</A>";
                  else
                    $_msg .= "<A href='./conductSteps.php?id=".$entryNo."&so=".$_staffOnly."&bD=2&fy=".$fiscalYear."&od=".$OrderDisplay."'>".(int)substr($entryNo,4)."</A>";
                  $_ii++;
                  $_msg .= "</TD>";
                  $_msg .= "<TD class='".$_class."'>" . mb_strimwidth($requester,0,14,'...','UTF-8') . "</TD>";
                  $_msg .= "<TD align='center' class='".$_class."'>" . date('m/d', strtotime($entryDate)) . "</TD>";
// ******                  $_msg .= "<TD class='".$_class."'>" . mb_strimwidth($eventTitle,0,36,'...',utf8) . "</TD>";
                  $_msg .= "<TD class='".$_class."'>" . mb_strimwidth($meetingTitle,0,34,'...') . "</TD>";
                  if ($_statuscode < 42 && strtotime($meetingDate) <= time()) {
                    $_str = "color='red'";
                  } else {
                    $_str = " ";
                  }
                  $_msg .= "<TD align='center' class='".$_class."'><FONT " . $_str . ">" . date('Y/m/d', strtotime($meetingDate)) . "</FONT></TD>";
                  $_msg .= "<TD align='center' class='".$_class."'>" . $reviewerJname . "</TD>";
                  $_msg .= "<TD align='center' class='".$_class."'>";
                  if ($_statuscode == 8)
                    $_msg .= "<FONT color='red'>〇</FONT>";
                  else
                    $_msg .= "&nbsp;";
                  $_msg .= "</TD>";
                  $_msg .= "<TD align='center' class='".$_class."'>";
                  if ($_statuscode == 10)
                    $_msg .= "<FONT color='red'>〇</FONT>";
                  else
                    $_msg .= "&nbsp;";
                  $_msg .= "</TD>";
                  $_msg .= "<TD align='center' class='".$_class."'>";
                  if ($_statuscode == 22)
                    $_msg .= "〇";
                  else
                    $_msg .= "&nbsp;";
                  $_msg .= "</TD>";
                  $_msg .= "<TD align='center' class='".$_class."'>";
                  if ($_statuscode == 32)
                    $_msg .= "<FONT color='red'>〇</FONT>";
                  else
                    $_msg .= "&nbsp;";
                  $_msg .= "</TD>";
                  $_msg .= "<TD align='center' class='".$_class."'>";
                  if ($_statuscode == 33)
                    $_msg .= "〇";
                  else
                    $_msg .= "&nbsp;";
                  $_msg .= "</TD>";
                  $_msg .= "<TD align='center' class='".$_class."'>";
                  if ($_statuscode == 34)
                    $_msg .= "<FONT color='red'>〇</FONT>";
                  else
                    $_msg .= "&nbsp;";
                  $_msg .= "</TD>";
                  $_msg .= "<TD align='center' class='".$_class."'>";
                  if ($_statuscode == 42)
                    $_msg .= "〇";
                  else
                    $_msg .= "&nbsp;";
                  $_msg .= "</TD>";
                  $_msg .= "</TR>\n";
                  echo $_msg;
                  
                } elseif ($chk_st42 && 42 == intval($ws2->getCell('AA'.$_row)->getValue())) {
                  
                  $entryNo = $ws2->getCell('B'.$_row)->getValue();
                  $requester = $ws2->getCell('C'.$_row)->getValue();
                  $eventTitle = $ws2->getCell('E'.$_row)->getValue();
                  
                  $_msg = "<TR align='left'>";
                  $_msg .= "<TD align='right' class='".$_class."'><A href='./displayEntry.php?id=".$entryNo."&so=".$_staffOnly."'>".(int)substr($entryNo,4)."</A></TD>";
                  $_ii++;
                  $_msg .= "<TD class='".$_class."'>" . mb_strimwidth($requester,0,14,'...',utf8) . "</TD>";
                  $_msg .= "<TD class='".$_class."'>" . mb_strimwidth($eventTitle,0,62,'...',utf8) . "</TD>";
                  $_msg .= "</TR>\n";
                  echo $_msg;
                  
                }
              }
              if ($_ii == 0) {
                if (!$chk_st42)
                  $_msg = "<TR><TD align='center' colspan='12' class='hpb-cnt-tb-cell2'>該当なし</TD></TR>\n";
                else
                  $_msg = "<TR><TD align='center' colspan='3' class='hpb-cnt-tb-cell2'>該当なし</TD></TR>\n";
                echo $_msg;
              }
              if ($_ii > 20)
                echo $_header;
              
              
              // Excelファイルへの書込み
              foreach($OrderSort as $_row) {
                
                if (($chk_st42 && 42 == intval($ws2->getCell('AA'.$_row)->getValue())) || !$chk_st42) {
                  if ($chk_st42) {
                    if ($cRow == 5) {
                      $ws3->getStyle('B2')->getFont()->setBold(true);
                      $ws3->getStyle('B2')->getFont()->setSize(14);
                      $ws3->setCellValue('B2','外部発表審査　'.$fiscalYear.'年度利用一覧　　　　(判定済み)');
                      $ws3->getStyle('F2')->getFont()->setSize(10);
                      $ws3->setCellValue('F2','　作成：'.date('Y/m/d H:i:s'));
                    }
                    $ws3->setCellValue('A'.$cRow,$cRow-4);
                    $ws3->setCellValue('B'.$cRow,$ws2->getCell('B'.$_row)->getValue());
                    $ws3->setCellValue('C'.$cRow,$ws2->getCell('C'.$_row)->getValue());
                    $ws3->setCellValue('D'.$cRow,$ws2->getCell('D'.$_row)->getValue());
                    $ws3->setCellValue('E'.$cRow,$ws2->getCell('E'.$_row)->getValue());
                    $ws3->setCellValue('F'.$cRow,$ws2->getCell('F'.$_row)->getValue());
                    $ws3->setCellValue('G'.$cRow,$ws2->getCell('G'.$_row)->getValue());
                    $ws3->setCellValue('H'.$cRow,$ws2->getCell('H'.$_row)->getValue());
                    $ws3->setCellValue('I'.$cRow,$ws2->getCell('I'.$_row)->getValue());
                    $ws3->setCellValue('J'.$cRow,$ws2->getCell('J'.$_row)->getValue());
                    $ws3->setCellValue('K'.$cRow,$ws2->getCell('K'.$_row)->getValue());
                    
                    $ws3->setCellValue('L'.$cRow,$ws2->getCell('L'.$_row)->getValue());
                    $ws3->setCellValue('M'.$cRow,$ws2->getCell('M'.$_row)->getValue());
                    $ws3->setCellValue('N'.$cRow,$ws2->getCell('N'.$_row)->getValue());
                    $ws3->setCellValue('O'.$cRow,$ws2->getCell('O'.$_row)->getValue());
                    $ws3->setCellValue('P'.$cRow,$ws2->getCell('P'.$_row)->getValue());
                    $ws3->setCellValue('Q'.$cRow,$ws2->getCell('Q'.$_row)->getValue());
                    $ws3->setCellValue('R'.$cRow,$ws2->getCell('R'.$_row)->getValue());
                    $ws3->setCellValue('S'.$cRow,$ws2->getCell('S'.$_row)->getValue());
                    
                    $ws3->setCellValue('V'.$cRow,$ws2->getCell('V'.$_row)->getValue());
                    $ws3->setCellValue('W'.$cRow,$ws2->getCell('W'.$_row)->getValue());
                    $ws3->setCellValue('X'.$cRow,$ws2->getCell('X'.$_row)->getValue());
                    $ws3->setCellValue('Y'.$cRow,$ws2->getCell('Y'.$_row)->getValue());
                    
                    $ws3->setCellValue('AA'.$cRow,$ws2->getCell('AA'.$_row)->getValue());
                    $ws3->setCellValue('AB'.$cRow,$ws2->getCell('AB'.$_row)->getValue());
                    $ws3->setCellValue('AC'.$cRow,$ws2->getCell('AC'.$_row)->getValue());
                    $ws3->setCellValue('AD'.$cRow,$ws2->getCell('AD'.$_row)->getValue());
                    $ws3->setCellValue('AE'.$cRow,$ws2->getCell('AE'.$_row)->getValue());
                    $ws3->setCellValue('AF'.$cRow,$ws2->getCell('AF'.$_row)->getValue());
                    $ws3->setCellValue('AG'.$cRow,$ws2->getCell('AG'.$_row)->getValue());
                    $ws3->setCellValue('AH'.$cRow,$ws2->getCell('AH'.$_row)->getValue());
                    $ws3->setCellValue('AI'.$cRow,$ws2->getCell('AI'.$_row)->getValue());
                    $ws3->setCellValue('AJ'.$cRow,$ws2->getCell('AJ'.$_row)->getValue());
                    
                  } else {
                    if ($cRow == 5) {
                      $ws3->getStyle('B2')->getFont()->setBold(true);
                      $ws3->getStyle('B2')->getFont()->setSize(14);
                      $ws3->setCellValue('B2','外部発表審査　'.$fiscalYear.'年度利用一覧');
                      $ws3->getStyle('D2')->getFont()->setSize(10);
                      $ws3->setCellValue('D2','　作成：'.date('Y/m/d H:i:s'));
                    }
                    $ws3->setCellValue('A'.$cRow,$ws2->getCell('B'.$_row)->getValue());
                    $ws3->setCellValue('B'.$cRow,$ws2->getCell('C'.$_row)->getValue());
                    $ws3->setCellValue('C'.$cRow,$ws2->getCell('E'.$_row)->getValue());
                    $ws3->setCellValue('D'.$cRow,$ws2->getCell('G'.$_row)->getValue());
                    $ws3->setCellValue('E'.$cRow,$ws2->getCell('H'.$_row)->getValue());
                    $ws3->setCellValue('F'.$cRow,$ws2->getCell('O'.$_row)->getValue());
                    $ws3->setCellValue('G'.$cRow,$ws2->getCell('AA'.$_row)->getValue());
                    
                  }
                  
                  unlink( $excelfilepath3 );
                  $writer3->save( $excelfilepath3 );
                  $cRow++;
                }
              }
              ?>
                
              </TBODY>
            </TABLE>
            <BR>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <FORM>
              <TBODY>
              <TR>
                <TD align="center" valign="top" class="hpb-dp-tb4-cell9">
                  <?php
                  if ($backDisplay == 2) {
                    $_msg = "中止し閉じる";
                    $_codename = "window.close()";
                  } elseif ($backDisplay == 6) {
                    $_msg = "中止し閉じる";
                    $_codename = "window.close()";
                  } else {
                    $_msg = "　管理に戻る　";
                    $_codename = "location.href='./staff_only.php'";
                  }
                  ?>
                  <INPUT type="button" name="" value="<?php echo $_msg ?>" onclick="<?php echo $_codename ?>">
                </TD>
              </TR>
              </TBODY>
              </FORM>
            </TABLE>
            
            <BR>
            <BR>
            <BR>
          </TD>
        </TR>
        </TBODY>
      </TABLE>
      
      </TD>
    </TR>
  </TBODY>
</TABLE>
</HTML>
