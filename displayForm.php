<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(申請)</TITLE>
<LINK href="./hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
<SCRIPT type="text/javascript"><!--
function checkDateFormat() {
  var datestr = document.form.meetingDate.value;
  // 正規表現による書式チェック
  if(!datestr.match(/^\d{4}\/\d{2}\/\d{2}$/)){
    document.form.meetingDate.focus();
    alert("書式が異なっています!");
    return false;
  }
  var vYear = datestr.substr(0, 4) - 0;
  var vMonth = datestr.substr(5, 2) - 1; // Javascriptは、0-11で表現
  var vDay = datestr.substr(8, 2) - 0;
  // 月,日の妥当性チェック
  if(vMonth >= 0 && vMonth <= 11 && vDay >= 1 && vDay <= 31){
    var vDt = new Date(vYear, vMonth, vDay);
    if(isNaN(vDt)){
      rtn = false;
    }else if(vDt.getFullYear() == vYear && vDt.getMonth() == vMonth && vDt.getDate() == vDay){
      rtn = true;
    }else{
      rtn = false;
    }
  }else{
    rtn = false;
  }
  if (!rtn) {
    document.form.meetingDate.focus();
    alert("日付が正しくありません!");
  }
  return rtn;
}
function wopen(fp) {
	window.open(fp, "", "resizable=yes,width=420,height=594");
}
// --></SCRIPT>
</HEAD>

<BODY>
<?php
// PhpSpreadsheet ライブラリー
require_once "./ad/phpspreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

// 文字コードセット
mb_language("Japanese");
mb_internal_encoding("UTF-8");

//  var_dump($_GET);

$_id = $_GET['id'];
$userID = $_GET['uid'];

if (strlen($_id)>3)
  $_id = substr($_id,0,3) . str_pad(substr($_id,3),5,0,STR_PAD_LEFT);

// echo "id=(".$_id.")<br>";
// echo "　part1:(".substr($_id,0,2)."), part2:(".substr($_id,3).")<br>";

$_staffOnly = 0;

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
                  <A href="./displayJpg.php"><IMG src="./img/hint.gif" alt="手続き" width="" height="" border="0"></A></TD>
                  <?php
                  $_msg = "";
                  if ($_staffOnly) {
                    $_msg = "<A href='javascript:void(0)' onclick=location.href='./ad/staff_only.php'>";
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
              $excelfilepath = dirname( __FILE__ ) . '/ad/data/' . $excelfilename;
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
                
// echo "compare: [".strncasecmp($_id,$_entryNo,8)."] (".$_id.")vs(".$_entryNo.")<br>";
                
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
            
// echo "currentRow=(".$cRow.")<br>";
            
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
              $statusCode = 0;
              $statusTime22 = "";
              $statusTime32 = "";
              $statusTime34 = "";
              $statusTime42 = "";
              $attachedFile_wo = "有";
              // $ref_file[0] = "";
              // $ref_file[1] = "";
              // $ref_file[2] = "";
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
              $statusCode = $ws2->getCell('AA'.$cRow)->getValue();
              $statusTime22 = $ws2->getCell('AC'.$cRow)->getValue();
              $statusTime32 = $ws2->getCell('AD'.$cRow)->getValue();
              $statusTime34 = $ws2->getCell('AI'.$cRow)->getValue();
              $statusTime42 = $ws2->getCell('AE'.$cRow)->getValue();
              $attachedFile_wo = $ws2->getCell('AK'.$cRow)->getValue();
              $ref_file[0] = $ws2->getCell('AL'.$cRow)->getValue();
              $ref_file[1] = $ws2->getCell('AM'.$cRow)->getValue();
              $ref_file[2] = $ws2->getCell('AN'.$cRow)->getValue();
              
              if ($statusCode == 8)
                $_update8 = TRUE;
              else
                $_update8 = FALSE;
              
              switch ((int)substr($entryNo,3,1)) {
                case 0:
                  if ($_update8) {
                    $_attribute = " " . "";
                    $_attribute2 = "";
                    $_attribute3 = " " . "disabled=''";
                    $_msg = "<FONT color='green'>審査は始まっていません　　修正できます</FONT>";
                  } else {
                    $_attribute = " " . "readonly";                        // itemの属性
                    $_attribute2 = " " . "disabled";                       // ボタンの属性
                    $_attribute3 = " " . "disabled=''";
                    $_msg = "";
                  }
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
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell9"><?php echo $_msg;?></TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <FORM method="post" name="form" action="_updateForm.php" onsubmit="return checkDateFormat();">
            
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
                  <INPUT type="text" name="entryDate" size="20" value="<?php echo $entryDate; ?>" disabled></TD>
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
                  <INPUT type="text" name="requesterEmail" size="40" value="<?php echo $requesterEmail; ?>" disabled></TD>
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
                  　<INPUT type="radio" name="attachedFile_wo" value="有"<?php if(!strcasecmp($attachedFile_wo,'有')){echo " checked";} echo $_attribute2 ?>> 有り　
                  <INPUT type="radio" name="attachedFile_wo" value="無"<?php if(strcasecmp($attachedFile_wo,'有')){echo " checked";} echo $_attribute2 ?>> 無し　
                </TD>
              </TR>
              <TR>
                <TD align="left" valign="center" rowspan="3" class="hpb-cnt-tb-cell1">資料ファイル<BR><FONT size="-2">　(<?php echo $attachment ?>)</TD>
                <TD height="60" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <?php
                  if (!$_update8) {
          /*          $filecount = 0;
                    foreach($ref_file as $file) {
                      if ($file == "")
                        $_str = "";
                      else
                        $_str = "<P>".++$filecount.". ".$file."</P>\n";
                      echo $_str;
                    }
           */       } else {
                    $_str = "<P><FONT size='-1'>　* 3件のファイルを添付できます。　　";
                    $_str .= "　</FONT><A href='javascript:void(0);' onclick=window.open('./maintainAttach_dup.php?tf=".$attachment."&so=".$_staffOnly."','_sub2','resizable=yes,width=780,height=480');><FONT size='-1'>削除または追加する</FONT></A></P>";
                    echo $_str;
                  }
                  $directory = "./ad/data/".$attachment;
                  $filecount = 0;
                  $filename = array();
                  $files = scandir($directory);
                  foreach($files as $file) {
                    if ($file != "." && $file != "..") {
                      $filename[$filecount] = $file;
                      $_str = "<P>".++$filecount.". <A href=javascript:wopen('".$directory."/".$file."');void(0); title='".substr($file,strrpos($file,'.')+1)."'>".$filename[$filecount-1]."</A></P>\n";
                      echo $_str;
                    }
                  }
                  ?>
                  &nbsp;</TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <?php
              if ($_update8) {
              ?>
              <TR>
                <TD colspan="2"><FONT size="-2" color="red">　　　資料ファイルを削除または追加する操作をした場合には画面の[再読込み]をして変更を確認してください。</FONT></TD>
              </TR>
              <?php
              }
              ?>
              <TR>
                <?php
                if ($_update8) {
                ?>
                <TD align="right" valign="top" class="hpb-dp-tb4-cell9">
                  <INPUT type="hidden" name="userID" value="<?php echo $userID; ?>">
                  <INPUT type="hidden" name="entryNo" value="<?php echo $entryNo; ?>">
                  <INPUT type="hidden" name="requesterEmail" value="<?php echo $requesterEmail; ?>">
                  <INPUT type="hidden" name="entryDate" value="<?php echo $entryDate; ?>">
                  <INPUT type="hidden" name="cRow" value="<?php echo $cRow; ?>">
                  <INPUT type="hidden" name="attachment" value="<?php echo $attachment; ?>">
                  <INPUT type="hidden" name="filename1" value="<?php echo $filename[0]; ?>">
                  <INPUT type="hidden" name="filename2" value="<?php echo $filename[1]; ?>">
                  <INPUT type="hidden" name="filename3" value="<?php echo $filename[2]; ?>">
                  <INPUT type="submit" name="" value="　申請を更新する　">
                </TD>
                <?php
                }
                ?>
                <TD align="center" valign="top" class="hpb-dp-tb4-cell9">
                  <INPUT type="button" name="" value="　申請履歴に戻る　" onclick="location.href='./index_Form.php?uid=<?php echo $userID ?>'"></TD>
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