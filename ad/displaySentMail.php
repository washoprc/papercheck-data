<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
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

/*
var_dump($_GET);
*/

if (!empty($_GET['cR']))
  if (is_numeric($_GET['cR']))
    $cRow = (int)$_GET['cR'];
  else
    $cRow = 5;
else
  $cRow = 5;
// echo "cRow=(".$cRow.")<br>";

if (!empty($_GET['mv']))
  if (substr($_GET['mv'],-1,1)=='p')
    $move = (int)substr($_GET['mv'],0,-1)+1;
  elseif (substr($_GET['mv'],-1,1)=='n')
    $move = (int)substr($_GET['mv'],0,-1)-1;
  else
    $move = 0;
else
  $move = 0;
// echo "move=(".$move.")<br>";

$_staffOnly = 1;

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
          <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
            <TBODY>
            <TR>
              <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                幹事が本システムから申請者／審査者に送信したメールを表示します。<BR>
                <BR>
              </TD>
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
          
          // メール送信回数
          if (!empty($ws2->getCell('AQ'.$cRow)->getValue()))
            $_mailCnt = (int)$ws2->getCell('AQ'.$cRow)->getValue();
          else
            $_mailCnt = 0;
          
          for ($i=0; $i<$_mailCnt; $i++) {
            list($type[$i],$to[$i],$header[$i],$subject[$i],$body[$i],$sendTime[$i]) = explode("|", $ws2->getCell(addColumn("AR",$i).$cRow)->getValue());
          }
          
          $ii = 0;
          if ($move > $_mailCnt)
            $ii = $_mailCnt;
          elseif ($move < 0)
            $ii = 0;
          else
            $ii = $move;
          
          ?>
          
          <FORM>
          <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
            <TBODY>
            <TR>
              <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
              <?php
              $_msg = "<A href='./displaySentMail.php?cR=".$cRow."&mv=".$ii."n'><</A>\n";
              $_msg .= " (".$_mailCnt.") \n";
              $_msg .= "<A href='./displaySentMail.php?cR=".$cRow."&mv=".$ii."p'>></A>\n";
              echo $_msg;
              ?>
              　　　　　　　<INPUT type="button" name="" value="　戻る　" onclick="window.close();"></TD>
            </TR>
            </TBODY>
          </TABLE>
          
          <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
            <TBODY>
            <?php
            $_msg = "<TR>\n";
              $_msg .= "<TD width='50' align='left' class='hpb-cnt-tb-cell1'>Sent</TD>\n";
                $_msg .= "<TD align='left' colspan='2' class='hpb-cnt-tb-cell2'>";
                  $_msg .= "<INPUT type='text' size='20' name='' value='".$sendTime[$ii]."' disabled></TD></TR>\n";
            $_msg .= "<TR>\n";
              $_msg .= "<TD width='50' align='left' class='hpb-cnt-tb-cell1'>To</TD>\n";
                $_msg .= "<TD align='left' class='hpb-cnt-tb-cell2'>";
                  $_msg .= "<INPUT type='text' size='54' name='' value='".$to[$ii]."' disabled></TD>";
                $_msg .= "<TD width='140' align='left' class='hpb-cnt-tb-cell2'>";
                $_msg .= "<INPUT type='radio' name='type'";
                if ($type[$ii]=='申請者')
                  $_msg .= " checked";
                $_msg .= " disabled>申請者";
                $_msg .= "　<INPUT type='radio' name='type'";
                if ($type[$ii]=='審査者')
                  $_msg .= " checked";
                $_msg .= " disabled>審査者";
                $_msg .= "</TD></TR>\n";
            $_msg .= "<TR>\n";
              $_msg .= "<TD width='50' align='left' class='hpb-cnt-tb-cell1'>Header </TD>\n";
                $_msg .= "<TD align='left' colspan='2' class='hpb-cnt-tb-cell2'>";
                  $_msg .= "<INPUT type='text' size='76' name='' value='".$header[$ii]."' disabled></TD></TR>\n";
            $_msg .= "<TR>\n";
              $_msg .= "<TD width='50' align='left' class='hpb-cnt-tb-cell1'>Subject </TD>\n";
                $_msg .= "<TD align='left' colspan='2' class='hpb-cnt-tb-cell2'>";
                  $_msg .= "<INPUT type='text' size='76' name='' value='".$subject[$ii]."' disabled></TD></TR>\n";
            $_msg .= "<TR>\n";
              $_msg .= "<TD width='50' align='left' class='hpb-cnt-tb-cell1'>Body</TD>\n";
                $_msg .= "<TD align='left' colspan='2' class='hpb-cnt-tb-cell2'>";
                  $_msg .= "<TEXTAREA name='' rows='10' cols='78' disabled>".$body[$ii]."</TEXTAREA></TD></TR>\n";
            echo $_msg;
            ?>
            </TBODY>
          </TABLE>
          </FORM>
          
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