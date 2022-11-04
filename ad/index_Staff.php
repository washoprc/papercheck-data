<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(割当て)</TITLE>
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

$_staffOnly_g = $_GET['so'];
$_staffOnly_p = $_POST['staffOnly'];

if (empty($_staffOnly_g) && empty($_staffOnly_p)) {
  $_staffOnly = 0;
} else if (empty($_staffOnly_g)) {
  $_staffOnly = intval($_staffOnly_p);
} else {
  $_staffOnly = intval($_staffOnly_g);
}
// echo "GET=(".$_staffOnly_g."), POST=(".$_staffOnly_p.") -> staffOnly=(".$_staffOnly.")<br>";
  
  
  $_loginUser = $_SERVER['PHP_AUTH_USER'];
  
  $excelfilename = 'EntrySheet.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/../ad/data/' . $excelfilename;
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
                <TD>　　Login-ID:　[<FONT color="green"><B><?php echo $_loginUser ?></B></FONT>]</TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
           
            <TABLE width="100%" border="1" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <FORM>
              <TBODY>
              <TR align="center">
                <TH width="20" class="hpb-cnt-tb-cell1">No</TH>
                <TH width="55" class="hpb-cnt-tb-cell1">申請者</TH>
                <TH width="45" class="hpb-cnt-tb-cell1">申請日</TH>
<!--               <TD width="1400" class="hpb-cnt-tb-cell1">題　目</TD> -->
                <TH class="hpb-cnt-tb-cell1">学術誌/会議名等</TH>
                <TH width="55" class="hpb-cnt-tb-cell1">会議日</TH>
                <TH width="45" class="hpb-cnt-tb-cell1">処理</TH>
              </TR>
              
              <?php
              $sRow = intval($ws1->getCell('B2')->getValue());
              
              $_ii = 0;
              $_row = $sRow;
              $_entryNo = $ws2->getCell('B'.$_row)->getValue();
              $_staffID = $ws2->getCell('M'.$_row)->getValue();
              $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
              while (isset($_entryNo) && $_entryNo != "eol") {
// echo "entryNo=(".$_entryNo."), Status=(".$_statuscode."), StaffID=(".$_staffID.")<br>";
                
//                if ($_loginUser == $_staffID) {                      // 申請に記録された幹事IDに関わらず表示する
                  
                  if ($_statuscode == 10) {                            // 幹事による審査者の設定待ちのものを抽出する
                    if ($_ii % 2==0)
                       $_class = "hpb-cnt-tb-cell2-a";
                     else
                       $_class = "hpb-cnt-tb-cell2-b";
                    
                    $requester = $ws2->getCell('C'.$_row)->getValue();
                    $entryDate = $ws2->getCell('AB'.$_row)->getValue();
                    $eventTitle = $ws2->getCell('E'.$_row)->getValue();
                    $meetingTitle = $ws2->getCell('G'.$_row)->getValue();
                    $meetingDate = $ws2->getCell('H'.$_row)->getValue();
                    
                    $_msg = "<TR align='left'>";
                    $_msg .= "<TD align='right' class='".$_class."'>" . (int)substr($_entryNo,4) . "</TD>";
                    $_ii++;
                    $_msg .= "<TD class='".$_class."'>" . mb_strimwidth($requester,0,12,'...',utf8) . "</TD>";
                    $_msg .= "<TD align='center' class='".$_class."'>" . date('m/d', strtotime($entryDate)) . "</TD>";
//                    $_msg .= "<TD class='".$_class."'>" . mb_strimwidth($eventTitle,0,36,'...',utf8) . "</TD>";
                    $_msg .= "<TD class='".$_class."'>" . mb_strimwidth($meetingTitle,0,34,'...',utf8) . "</TD>";
                    if (strtotime($meetingDate) <= time())
                      $_str = "color='red'";
                    else
                      $_str = " ";
                    $_msg .= "<TD align='center' class='".$_class."'><FONT " . $_str . ">" . date('Y/m/d', strtotime($meetingDate)) . "</FONT></TD>";                       
                    $_msg .= "<TD align='center' class='".$_class."'>";
                    $_msg .= "<INPUT type='button' name='action' value='設定' style='background-color:#b0c4de; border:1px solid #8E8E8E;' onclick=location.href='./assignReviewer.php?so=".$_staffOnly. "&id=".$_entryNo."'></TD>";
                    $_msg .= "</TR>\n";
                    echo $_msg;
                  }
//              }
                
                if ($_row >= 1000) {
                  break;
                } else {
                  $_row++;
                  $_entryNo = $ws2->getCell('B'.$_row)->getValue();
                  $_staffID = $ws2->getCell('M'.$_row)->getValue();
                  $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
                }
                
              }
              
              if ($_ii == 0) {
                $_msg = "<TR><TD align='center' colspan='6' class='hpb-cnt-tb-cell2'>該当なし</TD></TR>";
                echo $_msg;
              }
              ?>
              
              </TBODY>
              </FORM>
            </TABLE>
            <BR>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <FORM>
              <TBODY>
              <TR>
                <TD align="center" valign="top" class="hpb-dp-tb4-cell9">
                  <INPUT type="button" name="" value="　ホームに戻る　" onclick="location.href='../index.html'"></TD>
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
