<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(管理)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
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
require_once "phpspreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

// 文字コードセット
mb_language("Japanese");
mb_internal_encoding("UTF-8");

//  var_dump($_GET);

$_id = $_GET['id'];
$_staffOnly = $_GET['so'];
  
  
  if (strlen($_id)>3)
    $_id = substr($_id,0,3) . str_pad(substr($_id,3),5,0,STR_PAD_LEFT);
// echo "id=(".$_id.")<br>";
// echo "　part1:(".substr($_id,0,2)."), part2:(".substr($_id,3).")<br>";

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
                <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                  申請手続きで扱う項目を修正できます。<BR>
                  　修正を行った後に[更新]ボタンを押します。
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <?php
            if (empty($_id) || strlen($_id) != 8 || (!is_numeric(substr($_id,0,2)) || !is_numeric(substr($_id,3)))) {
               $_errorFlag = true;
               $_msg = "<FONT color='red'>　申請番号が正しくない為操作できません！</FONT>";
               $cRow = 0;
            } else {
              $excelfilename = 'EntrySheet.xlsx';
              $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
              $reader = new XlsxReader;
              $excel = $reader->load($excelfilepath);
              
              $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
              $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
              
              $sRow = intval($ws1->getCell('B2')->getValue());
              $sRow_reviewer = intval($ws1->getCell('B8')->getValue());
              
              // パラメータのentryNoを検索する
              $_row = $sRow;
              $_entryNo = $ws2->getCell('B'.$_row)->getValue();
              $_errorFlag = true;
              $_msg = "<FONT color='red'>　登録のない申請番号の為操作できません！</FONT>";
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
              $reviewerEmail = "";
              $comment1 = "";
              $comment2 = "";
              $decision = "";
              $closeNote = "";
              $statusCode = 0;
              $statusTime22 = "";
              $statusTime32 = "";
              $statusTime33 = "";
              $statusTime34 = "";
              $statusTime42 = "";
              $attachedFile_wo = "有";
              $_attribute = " " . "readonly";                            // 入力項目フィールドの属性
              $_attribute2 = " " . "disabled";                           // 操作ボタンの属性
              $_msg = $_msg;                                             // 表示メッセージ
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
              $reviewerEmail = $ws2->getCell('Q'.$cRow)->getValue();
              $comment1 = $ws2->getCell('R'.$cRow)->getValue();
              $comment2 = $ws2->getCell('S'.$cRow)->getValue();
              $decision = $ws2->getCell('V'.$cRow)->getValue();
              $closeNote = $ws2->getCell('W'.$cRow)->getValue();
              $statusCode = $ws2->getCell('AA'.$cRow)->getValue();
              $statusTime22 = $ws2->getCell('AC'.$cRow)->getValue();
              $statusTime32 = $ws2->getCell('AD'.$cRow)->getValue();
              $statusTime33 = $ws2->getCell('AH'.$cRow)->getValue();
              $statusTime34 = $ws2->getCell('AI'.$cRow)->getValue();
              $statusTime42 = $ws2->getCell('AE'.$cRow)->getValue();
              $attachedFile_wo = $ws2->getCell('AK'.$cRow)->getValue();
              switch ((int)substr($entryNo,3,1)) {
                case 0:
                  $_attribute = "";                                      // 入力項目フィールドの属性
                  $_attribute2 = "";                                     // 操作ボタンの属性
                  $_msg = "";                                            // 表示メッセージ
                  break;
                case 1:
                  $_attribute = "";
                  $_attribute2 = "";
                  $_msg = "<FONT color='green'>　　　** 試行中 **　　　　　　　</FONT>";
                  break;
               case 8:
                  $_attribute = "";
                  $_attribute2 = "";
                  $_msg = "<FONT color='blue'>　　手続き完了済み　　　　　　　</FONT>";
                  break;
               case 9:
                  $_attribute = "";
                  $_attribute2 = "";
                  $_msg = "<FONT color='red'>　　既に削除済み　　　　　　　　</FONT>";
                  break;
               default:
                  $_attribute = "";
                  $_attribute2 = "";
                  $_msg = "";
               }
            }
            ?>
            
            <FORM method="post" name="form" action="_updateEntry.php" onsubmit="return checkDateFormat();">
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                  <?php echo $_msg;?>
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <TD width="20%" height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">申請番号</TD>
                <TD width="80%" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="entryNo" size="20" value="<?php echo $entryNo; ?>" disabled></TD>
                  <INPUT type="hidden" name="entryNo" value="<?php echo $entryNo; ?>">
              </TR>
              <TR>
                <TD height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">申請日</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="entryDate" size="20" value="<?php echo $entryDate; ?>"<?php echo $_attribute ?>></TD>
              </TR>
              <TR>
                <TD height="5" colspan="2" class="hpb-cnt-tb-cell2"> </TD>
              </TR>
              <TR>
                <TD height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">申請者氏名</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="requester" size="30" value="<?php echo $requester; ?>"<?php echo $_attribute ?>></TD>
              </TR>
              <TR>
                <TD height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">　メールアドレス</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="requesterEmail" size="40" value="<?php echo $requesterEmail; ?>"<?php echo $_attribute ?>></TD>
              </TR>
              <TR>
                <TD height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">題目</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="eventTitle" rows="3" cols="60"<?php echo $_attribute ?>><?php echo $eventTitle; ?></TEXTAREA></TD>
              </TR>
              <TR>
                <TD height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">著者</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="author" rows="4" cols="60"<?php echo $_attribute ?>><?php echo $author; ?></TEXTAREA></TD>
              </TR>
              <TR>
                <TD height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">学術誌/会議名 等</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="meetingTitle" rows="3" cols="60"<?php echo $_attribute ?>><?php echo $meetingTitle; ?></TEXTAREA></TD>
              </TR>
              <TR>
                <TD height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">会議開催期間</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  from <INPUT type="text" name="meetingDate" size="12" value="<?php echo $meetingDate; ?>"<?php echo $_attribute ?>>
                  to <INPUT type="text" name="meetingDateTo" size="12" value="<?php echo $meetingDateTo; ?>"<?php echo $_attribute ?>></TD>
              </TR>
              <TR>
                <TD height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">論文の要点</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="abstract" rows="10" cols="60"<?php echo $_attribute ?>><?php echo $abstract; ?></TEXTAREA></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">添付ファイル有無</TD>
                <TD align="left" valign="middle" class="hpb-cnt-tb-cell2">
                  　<INPUT type="radio" name="attachedFile_wo" value="有"<?php if(!strcasecmp($attachedFile_wo,'有')){echo " checked";} echo $_attribute2 ?>> 有り　
                  <INPUT type="radio" name="attachedFile_wo" value=""<?php if(strcasecmp($attachedFile_wo,'有')){echo " checked";} echo $_attribute2 ?>> 無し　
                </TD>
              </TR>
              <TR>
                <TD align="left" valign="center" rowspan="3" class="hpb-cnt-tb-cell1">資料ファイル<BR><FONT size="-2">　(<?php echo $attachment ?>)</TD>
                <TD height="75" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <P><FONT size="-1">　* 3件のファイルを添付できます。　　
                     　</FONT><A href="javascript:void(0);" onclick="window.open('./maintainAttach.php?tf=<?php echo $attachment?>&so=<?php echo $_staffOnly ?>','_sub2','resizable=yes,width=780,height=480');"><FONT size="-1">削除または追加する</FONT></A></P>
                  <?php
                  $directory = "./data/".$attachment;
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
                  </TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            <TABLE class="hpb-cnt-tb1" cellspacing="0" cellpadding="5" width="100%" border="0">
              <TBODY>
              <TR>
                <TD width="20%" height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">審査者</TD>
                <TD width="80%" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <SELECT name="reviewer">
                  <?php
                  if (isset($sRow_reviewer)) {
                    $_row = $sRow_reviewer;
                    $_reviewer = $ws1->getCell('B'.$_row)->getValue();
                    while ($_reviewer != "eol" ) {
                      list($_reviewerJname, $_reviewerEname, $_reviewerEmail, $_reviewerActive) = explode("!", $_reviewer);                    
                      
                      if ($_reviewerActive >= 1) {
                        $Reviewers[$_reviewerActive] = $_reviewer;
                      }
                      
                      if ($_row >= 1000 ) {
                        break;
                      } else {
                        $_row++;
                        $_reviewer = $ws1->getCell('B'.$_row)->getValue();
                      }
                    }
                    
                    ksort($Reviewers);                   // 審査者順列番号で昇順にする
                    
                    $_msg = "<OPTION value='-'>-</OPTION>\n";
                    echo $_msg;
                    foreach($Reviewers as $Active=>$Reviewer) {                    
                      list($Jname_, $Ename_, $Email_, $Active_) = explode("!", $Reviewer);
                      
                      $_msg = "<OPTION value='";
                      $_msg .= $Jname_;
                      $_msg .= "!" . $Ename_;
                      $_msg .= "!" . $Email_ . "'";
                      if (!strcasecmp($Jname_, $reviewerJname))
                         $_msg .= " selected";
                      $_msg .= ">";
                      $_msg .= $Jname_ . " 先生</OPTION>\n";
                      echo $_msg;
                    }
                  } else {
                    $_msg = "<OPTION value='-'>-</OPTION>\n";
                    echo $_msg;
                  }
                  ?>
                  </SELECT>
                </TD>
              </TR>
              <TR>
                <TD height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">審査者設定日</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="statusTime22" size="20" value="<?php echo $statusTime22; ?>"<?php echo $_attribute ?>></TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            <TABLE class="hpb-cnt-tb1" cellspacing="0" cellpadding="5" width="100%" border="0">
              <TBODY>
              <TR>
                <TD width="20%" align="left" valign="center" class="hpb-cnt-tb-cell1">
                   コメント１<BR><BR>(会議/論文のアブストラクト等について)</TD>
                <TD width="80%" align="left" valign="top" class="hpb-cnt-tb-cell2">
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
            <TABLE class="hpb-cnt-tb1" cellspacing="0" cellpadding="5" width="100%" border="0">
              <TBODY>
<!--
              <TR>
                  <TD width="20%" align="left" valign="center" class="hpb-cnt-tb-cell1">
                  判定</TD>
                <TD width="80%" align="left" valign="middle" class="hpb-cnt-tb-cell2">　
                  <INPUT type="radio" name="decision" value="承認"<?php if(!strcasecmp($decision,'承認')){echo " checked";} echo $_attribute2 ?>> 承認する　
                  <INPUT type="radio" name="decision" value="不承認"<?php if(!strcasecmp($decision,'不承認')){echo " checked";} echo $_attribute2 ?>> 不承認　
                  <INPUT type="radio" name="decision" value="保留"<?php if(!strcasecmp($decision,'保留')){echo " checked";} echo $_attribute2 ?>> 保留する</TD>
              </TR>
-->
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
            <?php
              $_entryNo_status = substr($entryNo,3,1);
            ?>
            <TABLE class="hpb-cnt-tb1" cellspacing="0" cellpadding="5" width="100%" border="0">
              <TBODY>
              <TR>
                <TD width="20%" align="left" valign="center" class="hpb-cnt-tb-cell1">申請番号に付加する状況コード</TD>
                <TD width="80%" align="left" valign="middle" class="hpb-cnt-tb-cell2">
                  　<INPUT type="radio" name="entryNo_status" value="0"<?php if(!strcasecmp($_entryNo_status,'0')){echo " checked";} echo $_attribute2 ?>> 通常(0)　
                  <INPUT type="radio" name="entryNo_status" value="1"<?php if(!strcasecmp($_entryNo_status,'1')){echo " checked";} echo $_attribute2 ?>> 試行(1)　
                  <!-- 現在対応していない
                  <INPUT type="radio" name="entryNo_status" value="8"<?php if(!strcasecmp($_entryNo_status,'8')){echo " checked";} echo ' readonly' ?>> 完了(8)　
                  <INPUT type="radio" name="entryNo_status" value="9"<?php if(!strcasecmp($_entryNo_status,'9')){echo " checked";} echo ' readonly' ?>> 削除(9)　
                  -->
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            <TABLE class="hpb-cnt-tb1" cellspacing="0" cellpadding="5" width="100%" border="0">
              <TBODY>
              <TR>
                <TD width="20%" align="left" valign="center" class="hpb-cnt-tb-cell1">状況コード</TD>
                <TD width="80%" align="left" valign="middle" class="hpb-cnt-tb-cell2">
                  　<INPUT type="radio" name="statusCode" value="8"<?php if(!strcasecmp($statusCode,'8')){echo " checked";} echo $_attribute2 ?>> 資料ファイル待ち(08)　
                  <INPUT type="radio" name="statusCode" value="10"<?php if(!strcasecmp($statusCode,'10')){echo " checked";} echo $_attribute2 ?>> 申請済(10)　
                  <INPUT type="radio" name="statusCode" value="22"<?php if(!strcasecmp($statusCode,'22')){echo " checked";} echo $_attribute2 ?>> 審査者設定済(22)<BR>
                  　<INPUT type="radio" name="statusCode" value="32"<?php if(!strcasecmp($statusCode,'32')){echo " checked";} echo $_attribute2 ?>> 審査1済(32)　
                  <INPUT type="radio" name="statusCode" value="33"<?php if(!strcasecmp($statusCode,'33')){echo " checked";} echo $_attribute2 ?>> 審査1対応済(33)　
                  <INPUT type="radio" name="statusCode" value="34"<?php if(!strcasecmp($statusCode,'34')){echo " checked";} echo $_attribute2 ?>> 審査2済(34)<BR>
                  　<INPUT type="radio" name="statusCode" value="42"<?php if(!strcasecmp($statusCode,'42')){echo " checked";} echo $_attribute2 ?>> 審査2対応済(42)　
                  <INPUT type="radio" name="statusCode" value="21"<?php if(!strcasecmp($statusCode,'21')){echo " checked";} echo $_attribute2 ?>> 申請差戻し(21)　
                  <!-- 現在対応していない
                  <INPUT type="radio" name="statusCode" value="52"<?php if(!strcasecmp($statusCode,'52')){echo " checked";} echo $_attribute2 ?>> 完了済(52)　
                  -->
                  <INPUT type="radio" name="statusCode" value="90"<?php if(!strcasecmp($statusCode,'90')){echo " checked";} echo $_attribute2 ?>> 削除済(90)　
                  <INPUT type="hidden" name="statusCode_old" value="<?php echo $statusCode ?>">
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <TD width="20%" align="left" valign="center" class="hpb-cnt-tb-cell1">
                  cRow</TD>
                <TD width="80%" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="cRow" size="5" value="<?php echo $cRow ?>" disabled>
              </TR>
              </TBODY>
            </TABLE>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="right" valign="top" class="hpb-dp-tb4-cell9">
                  <INPUT type="hidden" name="attachment" value="<?php echo $attachment; ?>">
                  <INPUT type="hidden" name="filename1" value="<?php echo $filename[0]; ?>">
                  <INPUT type="hidden" name="filename2" value="<?php echo $filename[1]; ?>">
                  <INPUT type="hidden" name="filename3" value="<?php echo $filename[2]; ?>">
                  <INPUT type="hidden" name="cRow" value="<?php echo $cRow; ?>">
                  <INPUT type="hidden" name="statusTime33" value="<?php echo $statusTime33; ?>">
                  <INPUT type="submit" name="" value="　更新　"<?php echo $_attribute2; ?>>　
                </TD>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                  <INPUT type="button" name="" value="　中止し管理に戻る　" onclick="javascript:history.back();">
                </TD>
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