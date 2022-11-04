<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(管理)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
<STYLE type="text/css">
<!--
INPUT[type="submit"] {
   background-image: none;
   border: 1px solid #808080;
   border-radius: 0.3em;
}
--> 
</STYLE>
</HEAD>

<BODY>
<?php
// PhpSpreadsheet ライブラリー
require_once "phpspreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

//  var_dump($_GET);
//  var_dump($_POST);

if (isset($_POST['TallyBase']))
  $_TallyBase = $_POST['TallyBase'];
else
  $_TallyBase = '会議日基準';
$_staffOnly = $_POST['so'];
$_subwindow = $_GET['swin'];

include_once( dirname( __FILE__ ) . '/../functions.php' );

?>

<TABLE width="760" border="0" cellpadding="0" cellspacing="0" class="hpb-main">
  <TBODY>
    <TR>
      <TD>
      
      <TABLE width="613" border="0" align="center" cellpadding="0" cellspacing="0" class="hpb-lb-tb1">
        <TBODY>
        <TR>
          <TD class="hpb-lb-tb1-cell3"><BR>
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
            
            
            <?php
              $excelfilename = 'EntrySheet.xlsx';
              $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
              $reader = new XlsxReader;
              $excel = $reader->load($excelfilepath);
              
              $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
              $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
            ?>
             
            <BR>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR HEIGHT="40">
                
                <TD>　　審査者毎割当件数:　　</TD>
                <?php
                  if ($_subwindow !== '1') {
                ?>
                  <FORM method="post" action="./tallyReviewer.php">
                  <TD>
                    <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                    <INPUT type="checkbox" <?php if ($_TallyBase=='会議日基準') echo 'checked';?> disabled>
                    <INPUT type="submit" name="TallyBase" value="会議日基準">　/　
                    <INPUT type="checkbox" <?php if ($_TallyBase=='申請番号基準') echo 'checked';?> disabled>
                    <INPUT type="submit" name="TallyBase" value="申請番号基準">
                  </TD>
                  </FORM>
                <?php
                  }
                ?>
              </TR>
              </TBODY>
            </TABLE>
            
            <?php
              $sRow_reviewer = intval($ws1->getCell('B8')->getValue());
              
              $_ii = 0;
              $_row = $sRow_reviewer;
              $_reviewer = $ws1->getCell('B'.$_row)->getValue();
              while ($_reviewer != "eol" ) {
                
                list($_reviewerJname, $_reviewerEname, $_reviewerEmail, $_reviewerActive) = explode("!", $_reviewer);
                
                if ((int)$_reviewerActive >= 1)
                  $_ii++;
                
                if ($_row >= 1000 ) {
                  break;
                } else {
                  $_row++;
                  $_reviewer = $ws1->getCell('B'.$_row)->getValue();
                }
              }
              $no_reviewer = $_ii;
              
            ?>
            
            <TABLE width="531" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR align="center">
                <TD width="110" rowspan="2" class="hpb-cnt-tb-cell1">年度<BR><FONT size="-2">(<?php echo $_TallyBase?>)</FONT></TD>
                <TD colspan="<?php echo $no_reviewer+1; ?>" class="hpb-cnt-tb-cell1">審査者</TD>
              </TR>
              
              <TR align="center" height="20">
              <?php
                $_row = $sRow_reviewer;
                $_reviewer = $ws1->getCell('B'.$_row)->getValue();
                
                $_msg = "";
                while ($_reviewer != "eol" ) {
                  
                  list($_reviewerJname, $_reviewerEname, $_reviewerEmail, $_reviewerActive) = explode("!", $_reviewer);
                  
                  if ((int)$_reviewerActive >= 1) {
                    $_msg .= "<TD width='" . floor((531-110)/($no_reviewer+1)) ."' class='hpb-cnt-tb-cell1'>".$_reviewerJname."</TD>";
                    $reviewerEname[(int)$_reviewerActive] = $_reviewerEname;
                  }
                  if ($_row >= 1000 ) {
                    break;
                  } else {
                    $_row++;
                    $_reviewer = $ws1->getCell('B'.$_row)->getValue();
                  }
                }
                $_msg .= "<TD width='" . floor((531-110)/($no_reviewer+1)) ."' class='hpb-cnt-tb-cell1'>"."他"."</TD>\n";
                $reviewerEname[$no_reviewer+1] = "others";
                
                echo $_msg;
                
              ?>
              </TR>
              
              
              <?php
                $sRow = intval($ws1->getCell('B2')->getValue());
                $programStartYear = 2016;
                if ($_TallyBase == '申請番号基準') {
                  $fiscalyear = getThisFiscal('Y');
                } else {
                  $fiscalyear = $programStartYear;
                  $_row = $sRow;
                  $_entryNo = $ws2->getCell('B'.$_row)->getValue();
                  $_FiscalYear_Meeting = intval($ws2->getCell('X'.$_row)->getValue());
                  
                  while ($_entryNo != "eol" ) {
                    if ('0' == substr($_entryNo,3,1)) {
                      if ($fiscalyear < $_FiscalYear_Meeting) {
                        $fiscalyear = $_FiscalYear_Meeting;
                      }
                    }
                    
                    if ($_row >= 1000 ) {
                      break;
                    } else {
                      $_row++;
                      $_entryNo = $ws2->getCell('B'.$_row)->getValue();
                      $_FiscalYear_Meeting = intval($ws2->getCell('X'.$_row)->getValue());
                    }
                  }
                }
                
                
                while (true) {
                  
                  $event = 0;
                  $match = -1;
                  for($i=1; $i<=$no_reviewer+1; $i++) {
                    $counter[$i] = 0;
                  }
                  
                  $_row = $sRow;
                  $_entryNo = $ws2->getCell('B'.$_row)->getValue();
                  $_FiscalYear_Meeting = intval($ws2->getCell('X'.$_row)->getValue());
                  $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
                  
                  while (isset($_entryNo) && $_entryNo != "eol") {
                    
                    if ($_TallyBase == '申請番号基準') {
                      
                      if (substr($fiscalyear,-2).'-0' == substr($_entryNo,0,4)) {
                        if ($_statuscode > 10) {
                          $event++;
                          $match = 0;
                          for( $i = 1; $i <= $no_reviewer; $i++) {
                            if ($reviewerEname[$i] == $ws2->getCell('P'.$_row)->getValue()) {
                              $match++;
                              $counter[$i]++;
                            }
                          }
                          if ($match == 0) {
                            $counter[$no_reviewer+1]++;
                          }
                        }
                      }
                      
                    } else {
                      if ('0' == substr($_entryNo,3,1) && $fiscalyear == $_FiscalYear_Meeting) {
                        if ($_statuscode > 10) {
                          $event++;
                          $match = 0;
                          for( $i = 1; $i <= $no_reviewer; $i++) {
                            if ($reviewerEname[$i] == $ws2->getCell('P'.$_row)->getValue()) {
                              $match++;
                              $counter[$i]++;
                            }
                          }
                          if ($match == 0) {
                            $counter[$no_reviewer+1]++;
                          }
                        }
                      }
                      
                    }
                    
                    if ($_row >= 1000) {
                      break;
                    } else {
                      $_row++;
                      $_entryNo = $ws2->getCell('B'.$_row)->getValue();
                      $_FiscalYear_Meeting = intval($ws2->getCell('X'.$_row)->getValue());
                      $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
                    }
                  }
                  
                  $_msg = "<TR align='right'>\n";
                  $_msg .= "<TD align='center' class='hpb-cnt-tb-cell1'>".$fiscalyear."</TD>\n";
                  for ($i=1; $i<=$no_reviewer+1; $i++) {
                    $_msg .= "<TD class='hpb-cnt-tb-cell2'>".$counter[$i]."</TD>\n";
                  }
                  $_msg .= "</TR>\n";
                  echo $_msg;
                  
                  $fiscalyear--;
                  if ($fiscalyear < $programStartYear ) {
                    
                    //      echo "検索終了<br>";
                    break;
                  }
                }
              ?>
              
              </TBODY>
            </TABLE>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left">　　　<FONT size="-1">as of <?php echo date("Y/m/d H:i:s") ?></TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <FORM>
              <TBODY>
              <TR>
                <TD align="center" valign="top" class="hpb-dp-tb4-cell9">
                  <?php 
                    if ($_subwindow == 1)
                      echo "<INPUT type='button' value='　閉じる　' onclick='window.close()'></TD>\n";
                    else
                      echo "<INPUT type='button' value='　管理に戻る　' onclick=location.href='./staff_only.php'></TD>\n";
                  ?>
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
</BODY>
</HTML>