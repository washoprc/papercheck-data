<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(幹事)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
<SCRIPT type="text/javascript"><!--
function check() {
  if(document.form.reviewer.value == "***") {
    window.alert('選択されていません');
    document.form.reviewer.focus();
    return false;
  }
  return true;
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

//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

//  var_dump($_GET);
//  var_dump($_POST);

$_id = $_GET['id'];
$_staffOnly = $_GET['so'];
$backDisplay = (int)$_GET['bD'];

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
                  <A href="../displayJpg.php"><IMG src="../img/hint.gif" alt="手続き" width="" height="" border="0"></A>　
                  <A href='#' onclick=window.open('./summarizeByYear.php?so=<?php echo $_staffOnly ?>&bD=<?php echo $backDisplay ?>','_sub5','resizable=yes');return false;><IMG src="../img/chrome.png" alt="" width="" height="" border="0"></A></TD>
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
                  以下の申請がありましたので、これを担当する審査者を設定してください。<BR>
                  　　審査者リストには、ＰＲＣの教員を掲載しています。</TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            
            <?php
            if (empty($_id) || strlen($_id) != 8 || (!is_numeric(substr($_id,0,2)) || !is_numeric(substr($_id,3)))) {
               $_errorFlag = true;
               $_msg = "<FONT color='red'>　　申請番号が正しくない為操作できません！</FONT>";
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
              $_msg = "<FONT color='red'>　　登録のない申請番号の為操作できません！</FONT>";
              while (isset($_entryNo) && $_entryNo != "eol") {
                if (!strncasecmp(substr($_entryNo,3,1),"9",1)) {
                  // 申請番号に削除コードが含まれているため検索対象から除く
                } else {
// echo "compare: [".strncasecmp($_id,$_entryNo,8)."] (".$_id.")vs(".$_entryNo.")<br>";
                  
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
              $reviewerEname = "";
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
              $reviewerEname = $ws2->getCell('P'.$cRow)->getValue();
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
                  $_msg .= "<FONT color='green'>** 試行中 **</FONT>";
                  break;
                case 8:
                  $_attribute = " " . "disabled";
                  $_attribute2 = " " . "disabled";
                  $_msg .= "<FONT color='blue'>** 手続き完了済み **</FONT>";
                  break;
                case 9:
                  $_attribute = " " . "readonly";
                  $_attribute2 = " " . "disabled";
                  $_msg .= "<FONT color='red'>** 既に削除済み **</FONT>";
                  break;
                default:
                  $_attribute = " " . "readonly";
                  $_attribute2 = " " . "disabled";
                  $_msg = "";
              }
              $_msg2 = "";
              if ($statusCode>=22) {
                $_msg2 = "　　　--> <FONT color='blue'>既に設定済み</FONT>";
              }
            }
            ?>
            
            <FORM method="post" name="form" action="./_saveReviewer.php" onsubmit="return check();">
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
                     echo "リストから選択し[送信]をクリックすると選択者へ依頼メールが送信されます。" . $_msg;
                   }
                   ?>
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">　　
                  <SELECT name="reviewer">
                    <OPTION value="***">・・・
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
                    
                    foreach($Reviewers as $Active=>$Reviewer) {
                      list($Jname_, $Ename_, $Email_, $Active_) = explode("!", $Reviewer);
                      
                      $_msg = "<OPTION value='";
                      $_msg .= $Jname_;
                      $_msg .= "!" . $Ename_;
                      $_msg .= "!" . $Email_ . "'";
                      if (!strcmp($Ename_,$reviewerEname))
                        $_msg .= " selected";
                      $_msg .= ">";
                      $_msg .= $Jname_ . " 先生</OPTION>\n";
                      echo $_msg;
                    }
                  } else {
                    $_msg = "<OPTION value='-'>";
                    $_msg .= "-</OPTION>\n";
                    echo $_msg;
                  }
                  ?>
                  </SELECT>
                  <INPUT type="hidden" name="currentRow" value="<?php echo $cRow; ?>">
                  <INPUT type="hidden" name="so" value="<?php echo $_staffOnly; ?>">
                  <INPUT type="hidden" name="bD" value="<?php echo $backDisplay; ?>">
                  　<INPUT type="submit" name="ActBtn" value="　送信　" <?php echo $_attribute2; ?>>
                  　<?php echo $_msg2 ?>
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            <?php
            if (!$_errorFlag) {
            ?>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                   差戻しする場合には以下に説明を記述した後[差戻し]をクリックします。
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="suggestion" rows="6" cols="60"></TEXTAREA>
                  　<INPUT type="submit" name="ActBtn" value="　差戻し　" <?php echo $_attribute2; ?>>
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            <?php
            }
            ?>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="center">
                  <?php
                  if ($_staffOnly) {
                    if ($backDisplay==2) {
                      $_msg = "中止し閉じる";
                      $_codename = "window.close()";
                    } else {
                      $_msg = "中止し管理に戻る";
                      $_codename = "location.href='./staff_only.php'";
                    }
                  } else {
                    $_msg = "キャンセル";
                    $_codename = "location.href='./index_Staff.php?so=".$_staffOnly."'";
                  }
                  ?>
                  <INPUT type="button" name="" value="<?php echo $_msg ?>" onclick="<?php echo $_codename ?>">
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