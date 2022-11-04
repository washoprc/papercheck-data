<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(管理)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
<SCRIPT type="text/javascript"><!--
function wopen(fp) {
	window.open(fp, "", "resizable=yes,width=420,height=594");
}
// --></SCRIPT>
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

            
$_id = $_GET['id'];

if (strlen($_id)>3)
  $_id = substr($_id,0,3) . str_pad(substr($_id,3),5,0,STR_PAD_LEFT);

/*
echo "id=(".$_id.")<br>";
echo "　part1:(".substr($_id,0,2)."), part2:(".substr($_id,3).")<br>";
*/

$_staffOnly = 1;

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
            if (empty($_id) || strlen($_id) != 8 || (!is_numeric(substr($_id,0,2)) || !is_numeric(substr($_id,3)))) {
               $_errorFlag = true;
               $_msg = "<FONT color='red'>　　申請番号が正しくない為操作できません！</FONT>";
            } else {
              
              $excelfilename = 'EntrySheet.xlsx';
              $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
              $reader = new XlsxReader;
              $excel = $reader->load($excelfilepath);
              
              $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
              $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
              
              $sRow = intval($ws1->getCell('B2')->getValue());
              
              // パラメータのentryNoを検索する
              $_row = $sRow;
              $_entryNo = $ws2->getCell('B'.$_row)->getValue();
              $_errorFlag = true;
              $_msg = "<FONT color='red'>　　登録のない申請番号の為操作できません！</FONT>";
              while (isset($_entryNo) && $_entryNo != "eol") {
/*
echo "compare: [".strncasecmp($_id,$_entryNo,8)."] (".$_id.")vs(".$_entryNo.")<br>";
*/

                // 年部とシリアル部の一致を確認する
                if (!strcasecmp(substr($_id,0,3),substr($_entryNo,0,3)) && !strcasecmp(substr($_id,4,4),substr($_entryNo,4,4))) {
                  $_errorFlag = false;
                  $_msg = "";
                  break;
                }
                 
                if ($_row >= 1000) {
                  break;
                } else {
                  $_row++;
                  $_entryNo = $ws2->getCell('B'.$_row)->getValue();
                }
              }
              $cRow = $_row;
            }
/*
echo "currentRow=(".$cRow.")<br>";
*/
            
            if ($_errorFlag) {
              $entryNo = "　No input!　";
              $entryDate = "";
              $requester = "";
              $requesterEmail = "";
              $eventTitle = "";
              $author = "";
              $meetingTitle = "";
              $meetingDate = "";
              $abstract = "";
              $attachment = "-";
              $meetingDateTo = "";
              $reviewerJname = "";
              $comment1 = "";
              $comment2 = "";
              $decision = "";
              $closeNote = "";
              $statusTime22 = "";
              $statusTime32 = "";
              $statusTime34 = "";
              $statusTime42 = "";
              $attachedFile_wo = "有";
              $_attribute = " " . "readonly";
              $_attribute2 = " " . "disabled";
              $_attribute3 = " " . "disabled=''";
              $_msg = $_msg;
            } else {
              $entryNo = $ws2->getCell('B'.$cRow)->getValue();
              $entryDate = $ws2->getCell('AB'.$cRow)->getValue();
              $requester = $ws2->getCell('C'.$cRow)->getValue();
              $requesterEmail = $ws2->getCell('D'.$cRow)->getValue();
              $eventTitle = $ws2->getCell('E'.$cRow)->getValue();
              $author = $ws2->getCell('F'.$cRow)->getValue();
              $meetingTitle = $ws2->getCell('G'.$cRow)->getValue();
              $meetingDate = $ws2->getCell('H'.$cRow)->getValue();
              $abstract = $ws2->getCell('I'.$cRow)->getValue();
              $attachment = $ws2->getCell('J'.$cRow)->getValue();
              $meetingDateTo = $ws2->getCell('K'.$cRow)->getValue();
              $reviewerJname = $ws2->getCell('O'.$cRow)->getValue();
              $comment1 = $ws2->getCell('R'.$cRow)->getValue();
              $comment2 = $ws2->getCell('S'.$cRow)->getValue();
              $decision = $ws2->getCell('V'.$cRow)->getValue();
              $closeNote = $ws2->getCell('W'.$cRow)->getValue();
              $statusTime22 = $ws2->getCell('AC'.$cRow)->getValue();
              $statusTime32 = $ws2->getCell('AD'.$cRow)->getValue();
              $statusTime34 = $ws2->getCell('AI'.$cRow)->getValue();
              $statusTime42 = $ws2->getCell('AE'.$cRow)->getValue();
              $attachedFile_wo = $ws2->getCell('AK'.$cRow)->getValue();
              switch ((int)substr($entryNo,3,1)) {
                case 0:
                  $_attribute = " " . "readonly";                        // itemの属性
                  $_attribute2 = "";                                     // ボタンの属性
                  $_attribute3 = " " . "disabled=''";
                  $_msg = "";
                  break;
                case 1:
                  $_attribute = " " . "readonly";
                  $_attribute2 = "";
                  $_attribute3 = " " . "disabled=''";
                  $_msg = "<FONT color='green'>　　　** 試行中 **　　　　　　　</FONT>";
                  break;
               case 8:
                  $_attribute = " " . "disabled";
                  $_attribute2 = " " . "disabled";
                  $_attribute3 = " " . "disabled=''";
                  $_msg = "<FONT color='blue'>　　手続き完了済み　　　　　　　</FONT>";
                  break;
               case 9:
                  $_attribute = " " . "readonly";
                  $_attribute2 = " " . "disabled";
                  $_attribute3 = " " . "disabled=''";
                  $_msg = "<FONT color='red'>　　既に削除済み　　　　　　　　</FONT>";
                  break;
               default:
                  $_attribute = " " . "readonly";
                  $_attribute2 = " " . "disabled";
                  $_attribute3 = " " . "disabled=''";
                  $_msg = "";
               }
            }
            ?>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <FORM>
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                  <?php echo $_msg;?>　　　　　　　
                  <INPUT type="button" name="" value="　管理に戻る　" onclick="history.back()"></TD>
              </TR>
              </TBODY>
              </FORM>
            </TABLE>
            
            <FORM>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <TD width="20%" align="left" valign="center" class="hpb-cnt-tb-cell1">受付番号</TD>
                <TD width="80%" align="left" valign="center" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="entryNo" size="20" value="<?php echo $entryNo; ?>" disabled></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">受付日</TD>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="entryDate" size="20" value="<?php echo $entryDate; ?>"<?php echo $_attribute ?>></TD>
              </TR>
              <TR>
                <TD height="5" colspan="2" class="hpb-cnt-tb-cell2"> </TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">申請者氏名</TD>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="requester" size="30" value="<?php echo $requester; ?>"<?php echo $_attribute ?>></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">　メールアドレス</TD>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="requesterEmail" size="40" value="<?php echo $requesterEmail; ?>"<?php echo $_attribute ?>></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">題目</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="eventTitle" rows="3" cols="60"<?php echo $_attribute ?>><?php echo $eventTitle; ?></TEXTAREA></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">著者</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="author" rows="4" cols="60"<?php echo $_attribute ?>><?php echo $author; ?></TEXTAREA></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">学術誌/会議名 等</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="meetingTitle" rows="3" cols="60"<?php echo $_attribute ?>><?php echo $meetingTitle; ?></TEXTAREA></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">会議開催期間</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  from <INPUT type="text" name="meetingDate" size="12" value="<?php echo $meetingDate; ?>"<?php echo $_attribute ?>>
                  to <INPUT type="text" name="meetingDateTo" size="12" value="<?php echo $meetingDateTo; ?>"<?php echo $_attribute ?>></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">論文の要点</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="abstract" rows="10" cols="60"<?php echo $_attribute ?>><?php echo $abstract; ?></TEXTAREA></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">添付ファイル有無</TD>
                <TD align="left" valign="middle" class="hpb-cnt-tb-cell2">
                  　<INPUT type="radio" name="attachedFile_wo" value="有"<?php if(!strcasecmp($attachedFile_wo,'有')){echo " checked";} echo $_attribute3 ?>> 有り　
                  <INPUT type="radio" name="attachedFile_wo" value="無"<?php if(strcasecmp($attachedFile_wo,'有')){echo " checked";} echo $_attribute3 ?>> 無し　
                </TD>
              </TR>
              <TR>
                <TD align="left" valign="center" rowspan="3" class="hpb-cnt-tb-cell1">資料ファイル</TD>
                <TD height="60" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <?php
                  $directory = "./data/".$attachment;
                  $filecount = 0;
                  $files = scandir($directory);
                  foreach($files as $file) {
                    if ($file != "." && $file != "..") {
                      $_str = "<P>".++$filecount.". <A href=javascript:wopen('".$directory."/".$file."');void(0); title='".substr($file,strrpos($file,'.')+1)."'>".$file."</A></P>\n";
                      echo $_str;
                    }
                  }
                  ?>
                  &nbsp;</TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <TD width="20%" align="left" valign="center" class="hpb-cnt-tb-cell1">審査者</TD>
                <TD width="80%" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="reviewerJname" size="30" 
                     value="<?php if (!empty($reviewerJname)) {echo $reviewerJname.' 先生';} else {echo $reviewerJname;} ?>"<?php echo $_attribute ?>></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">審査者設定日</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="statusTime22" size="20" value="<?php echo $statusTime22; ?>"<?php echo $_attribute ?>></TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">
                    コメント１<BR><BR>(会議/論文のアブストラクト等について)</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                    <TEXTAREA name="comment1" rows="8" cols="60"<?php echo $_attribute ?>><?php echo $comment1; ?></TEXTAREA></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">審査日</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="statusTime32" size="20" value="<?php echo $statusTime32; ?>"<?php echo $_attribute ?>></TD>
              </TR>
              <TR>
                <TD height="5" colspan="2" class="hpb-cnt-tb-cell2"> </TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">
                    コメント２<BR><BR>(本論文へのコメント等について)</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                    <TEXTAREA name="comment2" rows="8" cols="60"<?php echo $_attribute ?>><?php echo $comment2; ?></TEXTAREA></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">審査日</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="statusTime34" size="20" value="<?php echo $statusTime34; ?>"<?php echo $_attribute ?>></TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <TD width="20%" height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">
                  判定</TD>
                <TD width="80%" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="radio" name="decision" value="承認"<?php if(!strcasecmp($decision,'承認')){echo " checked";} echo $_attribute3; ?>>　承認する
                  <INPUT type="radio" name="decision" value="不承認"<?php if(!strcasecmp($decision,'不承認')){echo " checked";} echo $_attribute3; ?>>　不承認　
                  <INPUT type="radio" name="decision" value="保留"<?php if(!strcasecmp($decision,'保留')){echo " checked";} echo $_attribute3; ?>>　保留する　</TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">
                   委員会としてのコメント/特記など</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="closeNote" rows="8" cols="60"<?php echo $_attribute ?>><?php echo $closeNote; ?></TEXTAREA></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">判定日</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="statusTime42" size="20" value="<?php echo $statusTime42; ?>"<?php echo $_attribute ?>></TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <TD width="20%" height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">
                  cRow</TD>
                <TD width="80%" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="cRow" size="5" value="<?php echo $cRow ?>" disabled>
              </TR>
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