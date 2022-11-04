<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(審査)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
<SCRIPT type="text/javascript"><!--
function check() {
  if(document.form.comment1.value == "") {
    if(document.form.comment2.value == ""){
      alert("入力されていません!");
      document.form.comment1.focus();
      return false;
    }
  }
  return true;
}
function wopen(fp) {
	window.open(fp, "", "resizable=yes width=420,height=594");
}
// --></SCRIPT>
</HEAD>

<BODY>
<?php
// PhpSpreadsheet ライブラリー
require_once "../ad/phpspreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

/*
var_dump($_GET);
var_dump($_POST);
*/

$_id = $_GET['id'];
$_staffOnly = $_GET['so'];

if (strlen($_id)>3)
  $_id = substr($_id,0,3) . str_pad(substr($_id,3),5,0,STR_PAD_LEFT);

/*
echo "id=(".$_id.")<br>";
echo "　part1:(".substr($_id,0,2)."), part2:(".substr($_id,3).")<br>";
*/
$_loginID = $_SERVER['PHP_AUTH_USER'];

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
                    $_msg = "<A href='javascript:void(0)' onclick=location.href='../ad/staff_only.php'>";
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
                  申請がありましたの、事前審査を行ってください。<BR>
                  <BR>
                  申請の会議日前日までに完了お願いします。<BR>
                  </TD>
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
              $excelfilepath = dirname( __FILE__ ) . '/../ad/data/' . $excelfilename;
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
                if (!strncasecmp(substr($_entryNo,3,1),"9",1)) {
                  
                } else {
/*
echo "compare: [".strncasecmp($_id,$_entryNo,8)."] (".$_id.")vs(".$_entryNo.")<br>";
*/
                  // 年部とシリアル部の一致を確認する
                  if (!strcasecmp(substr($_id,0,3),substr($_entryNo,0,3)) && !strcasecmp(substr($_id,4,4),substr($_entryNo,4,4))) {
                    $_errorFlag = false;
                    $_msg = "";
                    break;
                  }
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
            
            if (!$_errorFlag) {
              // ログインIDが申請番号の審査者IDと一致することを確認
              $reviewerEname = $ws2->getCell('P'.$cRow)->getValue();
/*
echo "審査者ID=(".$reviewerEname.")<br>";
echo "ログインID=(".$_loginID.")<br>";
*/
              if ($_loginID != $reviewerEname && !$_staffOnly) {
                $_errorFlag = true;
                $_msg = "<FONT color='red'>　　審査する申請番号ではありません！</FONT>";
              }
            }
            
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
              $_attribute = " " . "readonly";
              $_attribute2 = " " . "disabled";
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
              $statusCode = $ws2->getCell('AA'.$cRow)->getValue();
              
             $_msg = "<br>　　　";
              switch ((int)substr($entryNo,3,1)) {
                case 0:
                  $_attribute = " " . "readonly";
                  $_attribute2 = "";
                  $_msg = "";
                  break;
                case 1:
                  $_attribute = " " . "readonly";
                  $_attribute2 = "";
                  $_msg = "<FONT color='green'>** 試行中 **</FONT>";
                  break;
                case 8:
                  $_attribute = " " . "disabled";
                  $_attribute2 = " " . "disabled";
                  $_msg = "<FONT color='brue'>手続き完了済み</FONT>";
                  break;
                case 9:
                  $_attribute = " " . "readonly";
                  $_attribute2 = " " . "disabled";
                  $_msg = "<FONT color='red'>既に削除済み</FONT>";
                  break;
                default:
                  $_attribute = " " . "readonly";
                  $_attribute2 = " " . "disabled";
                  $_msg = "";
              }
              
              // 審査者が処理を行い幹事が確認を行った場合、審査者は入力の修正を行えない
              
              if ($_staffOnly && strncasecmp(substr($entryNo,3,1),"1",1) && $statusCode >= 42) {
                $_errorFlag = true;
                $_attribute = " " . "readonly";
                $_attribute2 = " " . "disabled";
                $_msg = "<FONT color='red'>　　審査は完了しているので修正できません!</FONT>";
              } elseif ($statusCode>=34) {
                $_msg2 = "　　　--> <FONT color='blue'>既に審査済み</FONT>";
                if (!$_staffOnly) {
                  $_attribute = " " . "readonly";
                  $_attribute2 = " " . "disabled";
                }
              } else {
                $_msg2 = "";
                  $_attribute = "";
                  $_attribute2 = "";
              }
            }
            ?>
            
            <FORM method="post" name="form" action="./_saveComment.php" onsubmit="return check();">
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
                <TR>
                 <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                  以下は申請者の入力したものです。　修正はできません。</TD>
                </TR>
              </TBODY>
            </TABLE>
            
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
                <TR>
                  <TD width="20%" align="left" valign="center" class="hpb-cnt-tb-cell1">申請番号</TD>
                  <TD width="80%" align="left" valign="center" class="hpb-cnt-tb-cell2">
                    <INPUT type="text" name="entryNo" size="20" value="<?php echo $entryNo; ?>" disabled></TD>
                    <INPUT type="hidden" name="entryNo" value="<?php echo $entryNo; ?>">
                </TR>
                <TR>
                  <TD align="left" valign="center" class="hpb-cnt-tb-cell1">申請日</TD>
                  <TD align="left" valign="center" class="hpb-cnt-tb-cell2">
                    <INPUT type="text" name="entryDate" size="20" value="<?php echo $entryDate; ?>" readonly></TD>
                </TR>
                <TR>
                  <TD height="5" colspan="2" class="hpb-cnt-tb-cell2"> </TD>
                </TR>
                <TR>
                  <TD align="left" valign="center" class="hpb-cnt-tb-cell1">申請者氏名</TD>
                  <TD align="left" valign="center" class="hpb-cnt-tb-cell2">
                    <INPUT type="text" name="requester" size="30" value="<?php echo $requester; ?>" readonly></TD>
                </TR>
                <TR>
                  <TD align="left" valign="center" class="hpb-cnt-tb-cell1">メールアドレス</TD>
                  <TD align="left" valign="center" class="hpb-cnt-tb-cell2">
                    <INPUT type="text" name="requesterEmail" size="40" value="<?php echo $requesterEmail; ?>" readonly></TD>
                </TR>
                <TR>
                  <TD align="left" valign="center" class="hpb-cnt-tb-cell1">題目</TD>
                  <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                    <TEXTAREA name="eventTitle" rows="3" cols="60" readonly><?php echo $eventTitle; ?></TEXTAREA></TD>
                </TR>
                <TR>
                  <TD align="left" valign="center" class="hpb-cnt-tb-cell1">著者</TD>
                  <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                    <TEXTAREA name="author" rows="4" cols="60" readonly><?php echo $author; ?></TEXTAREA></TD>
                </TR>
                <TR>
                  <TD align="left" valign="center" class="hpb-cnt-tb-cell1">学術誌/会議名 等</TD>
                  <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                    <TEXTAREA name="meetingTitle" rows="3" cols="60" readonly><?php echo $meetingTitle; ?></TEXTAREA></TD>
                </TR>
                <TR>
                  <TD align="left" valign="center" class="hpb-cnt-tb-cell1">会議開催期間</TD>
                  <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                    from <INPUT type="text" name="meetingDate" size="12" value="<?php echo $meetingDate; ?>" readonly>
                    to <INPUT type="text" name="meetingDateTo" size="12" value="<?php echo $meetingDateTo; ?>" readonly></TD>
                </TR>
                <TR>
                  <TD align="left" valign="center" class="hpb-cnt-tb-cell1">論文の要点</TD>
                  <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                    <TEXTAREA name="abstract" rows="10" cols="60" readonly><?php echo $abstract; ?></TEXTAREA></TD>
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
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD><HR align="center" class="hpb-hr-prc-input"></TD>
              </TR>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                  <?php
                  if ($_errorFlag) {
                    echo $_msg;
                  } else {
                    echo "コメントを記載して、[送信]をクリックしてください。" . $_msg;
                  }
                  ?>
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <TD width="20%" align="left" valign="center" class="hpb-cnt-tb-cell1">審査者</TD>
                <TD width="80%" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="reviewerJname" size="30"
                    value="<?php if (!empty($reviewerJname)) {echo $reviewerJname.' 先生';} else {echo $reviewerJname;} ?>" disabled>
                  <?php echo $_msg2; ?>
                  </TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <?php
                if ($statusCode == 22) {
                  $_attribute = $_attribute2 = "";
                } elseif ($statusCode == 33) {
                  if ($comment1 !== "" && $comment2 == "") {
                    $_attribute1 = "readonly";
                    $_attribute2 = "required";
                  } elseif ($comment1 == "" && $comment2 !== "") {
                    $_attribute1 = "required";
                    $_attribute2 = "readonly";
                  }
                }
              ?>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">
                   コメント１</FONT><BR><BR>(会議/論文のアブストラクト等について)</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="comment1" rows="8" cols="60" <?php echo $_attribute1 ?>><?php echo $comment1; ?></TEXTAREA></TD>
              </TR>
              <TR>
                <TD height="5" colspan="2" class="hpb-cnt-tb-cell2"> </TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">
                   コメント２</FONT><BR><BR>(本論文へのコメント等について)</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="comment2" rows="8" cols="60" <?php echo $_attribute2 ?>><?php echo $comment2; ?></TEXTAREA></TD>
              </TR>
              </TBODY>
            </TABLE>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
                 <TR>
                  <TD align="right" valign="top" class="hpb-dp-tb4-cell9">
                    <INPUT type="hidden" name="currentRow" value="<?php echo $cRow ?>">
                    <INPUT type="hidden" name="statusCode" value="<?php echo $statusCode ?>">
                    <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                    <INPUT type="submit" name="do" value="　送信　"<?php echo $_attribute2; ?>>　
                    <INPUT type="submit" name="do" value="一時保存"<?php echo $_attribute2; ?>></TD>
                  <TD align="left" valign="top" class="hpb-dp-tb4-cell9">　
                    <?php
                    if ($_staffOnly) {
                      $_msg = "　中止し管理に戻る　";
                      $_codename = "'../ad/staff_only.php'";
                    } else {
                      $_msg = "審査一覧に戻る";
                      $_codename = "'./index_Comment.php?so=".$_staffOnly."'";
                    }
                    ?>
                    <INPUT type="button" name="" value="<?php echo $_msg ?>" onclick="location.href=<?php echo $_codename ?>"></TD>
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