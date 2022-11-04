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

// 文字コードセット
mb_language("Japanese");
mb_internal_encoding("UTF-8");

//  var_dump($_GET);
//  var_dump($_POST);

$_staffOnly = $_POST['so'];

$statuscode_g = $_GET['sCS'];
$statuscode_p = $_POST['statuscode'];

if (empty($statuscode_g) && empty($statuscode_p)) {
  $statuscode = 32;
} else if (empty($statuscode_g)) {
  $statuscode = intval($statuscode_p);
} else {
  $statuscode = intval($statuscode_g);
}

// echo "GET=(".$statuscode_g."), POST=(".$statuscode_p.") -> statuscode=(".$statuscode.")<br>";

switch ($statuscode) {
  case 10:
    $statuscode_msg = "申請";
    break;
  case 21:
    $statuscode_msg = "審査差戻し";
    break;
  case 22:
    $statuscode_msg = "審査者設定済み";
    break;
  case 32:
    $statuscode_msg = "審査1済み";
    break;
  case 33:
    $statuscode_msg = "対応済み";
    break;
  case 34:
    $statuscode_msg = "審査2済み";
    break;
  case 42;
    $statuscode_msg = "確認済み";
    break;
/*
  case 52:
    $statuscode_msg = "完了済み";
    break;
*/
  case 90:
    $statuscode_msg = "削除済み";
    break;
  default:
    $statuscode = 32;
    $statuscode_msg = "コメント入力済み";
}

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
                <TD>　　検索結果:　Status: <?php echo $statuscode_msg ?></TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            <TABLE width="100%" border="1" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <?php
              $_msg = "<TR align='center'>";
              $_msg .= "<TH width='25' class='hpb-cnt-tb-cell1'>No</TH>";
              $_msg .= "<TH width='105' class='hpb-cnt-tb-cell1'>申請者</TH>";
              $_msg .= "<TH class='hpb-cnt-tb-cell1'>題　目</TH>";
              $_msg .= "</TR>";
              echo $_msg;
              $_header = $_msg;
              
              $sRow = intval($ws1->getCell('B2')->getValue());
              
              $_ii = 0;
              $_row = $sRow;
              $_entryNo = $ws2->getCell('B'.$_row)->getValue();
              $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
              while (isset($_entryNo) && $_entryNo != "eol") {
// echo "Value=(".$_entryNo."), StatusCode=(".$_statuscode.")<br>";
                
                if ($statuscode == $_statuscode) {
                  $requester = $ws2->getCell('C'.$_row)->getValue();
                  $eventTitle = $ws2->getCell('E'.$_row)->getValue();
                  
                  if ($_ii % 2==0)
                    $_class = "hpb-cnt-tb-cell2-a";
                  else
                    $_class = "hpb-cnt-tb-cell2-b";
                  
                  $_msg = "<TR align='left'>";
                  $_msg .= "<TD align='right' class='".$_class."'><A href='./displayEntry.php?id=".$_entryNo."&so=".$_staffOnly."&bD=1&sCS=".$statuscode."'>".(int)substr($_entryNo,4)."</A></TD>";
                  $_msg .= "<TD class='".$_class."'>" . mb_strimwidth($requester,0,14,'...',utf8) . "</TD>";
                  $_msg .= "<TD class='".$_class."'>" . mb_strimwidth($eventTitle,0,62,'...',utf8) . "</TD>";
                  $_msg .= "</TR>\n";
                  $_ii++;
                  echo $_msg;
                }
                
                if ($_row >= 1000) {
                  break;
                } else {
                  $_row++;
                  $_entryNo = $ws2->getCell('B'.$_row)->getValue();
                  $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
                }
              }
              if ($_ii == 0) {
                $_msg = "<TR><TD align='center' colspan='3' class='hpb-cnt-tb-cell2'>該当なし</TD></TR>";
                echo $_msg;
              }
              if ($_ii > 20)
                echo $_header;
              ?>
                
              </TBODY>
            </TABLE>
            <BR>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <FORM>
              <TBODY>
              <TR>
                <TD align="center" valign="top" class="hpb-dp-tb4-cell9">
                  <INPUT type="button" name="" value="　管理に戻る　" onclick="location.href='./staff_only.php'"></TD>
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
