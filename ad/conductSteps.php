<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(幹事)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
<SCRIPT type="text/javascript">
<!--
function wopen(fp) {
	window.open(fp, "", "resizable=yes,width=420,height=594");
}
// -->
</SCRIPT>
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

/*
var_dump($_GET);
var_dump($_POST);
*/

$_id = $_GET['id'];
$_staffOnly = $_GET['so'];
$backDisplay = $_GET['bD'];
$statusCodeShow = $_GET['sCS'];
$fiscalYear = $_GET['fy'];
$OrderDisplay = $_GET['od'];

if (strlen($_id)>3)
  $_id = substr($_id,0,3) . str_pad(substr($_id,3),5,0,STR_PAD_LEFT);

/*
echo "id=(".$_id.")<br>";
echo "　part1:(".substr($_id,0,2)."), part2:(".substr($_id,3).")<br>";
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
                <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                  審査者による入力が完了されましたの、本件の完了処理を行ってください。<BR>
                  <BR>
                  この処理により審査者のコメントが審査者にメールされます。<BR>
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
              $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
              $reader = new XlsxReader;
              $excel = $reader->load($excelfilepath);
              
              $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
              $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
              
              $sRow = intval($ws1->getCell('B2')->getValue());
              
              // 幹事の氏名とメールアドレス
              $staff = $ws1->getCell('B4')->getValue();
              list($staffJname, $staffEname, $staffEmail) = explode("!", $staff);
              
              // パラメータのentryNoを検索する
              $_row = $sRow;
              $_entryNo = $ws2->getCell('B'.$_row)->getValue();
              $_errorFlag = true;
              $_msg = "<FONT color='red'>　　登録のない申請番号の為操作できません！</FONT>";
              while (isset($_entryNo) && $_entryNo != "eol") {
                if (!strncasecmp(substr($_entryNo,3,1),"9",1)) {
                  // 申請番号に削除コードが含まれているため検索対象から除く
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
              $decision = "-";
              $closeNote = "無し";
              $mailCnt = 0;
              $statusTime22 = "";
              $statusTime32 = "";
              $statusTime33 = "";
              $statusTime34 = "";
              $statusTime42 = "";
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
              $reviewerEmail = $ws2->getCell('Q'.$cRow)->getValue();
              $comment1 = $ws2->getCell('R'.$cRow)->getValue();
              $comment2 = $ws2->getCell('S'.$cRow)->getValue();
              $decision = $ws2->getCell('V'.$cRow)->getValue();
              $closeNote = $ws2->getCell('W'.$cRow)->getValue();
              $mailCnt = $ws2->getCell('AQ'.$cRow)->getValue();
              $statusTime22 = $ws2->getCell('AC'.$cRow)->getValue();
              $statusTime32 = $ws2->getCell('AD'.$cRow)->getValue();
              $statusTime33 = $ws2->getCell('AH'.$cRow)->getValue();
              $statusTime34 = $ws2->getCell('AI'.$cRow)->getValue();
              $statusTime42 = $ws2->getCell('AE'.$cRow)->getValue();
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
                  $_msg = "<FONT color='blue'>手続き完了済み</FONT>";
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
              $_msg2 = "";
              if ($statusCode>=42) {
                $_msg2 = "　　　--> <FONT color='blue'>既に判定済み</FONT>";
              }
            }
            ?>
            
            <FORM method="post" name="" action="_saveSteps.php";>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                  以下は申請者(上)と審査者(下)が入力したものです。　修正はできません。</TD>
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
                    from <INPUT type="text" name="meetingDate" size="12" value="<?php echo $meetingDate; ?>" readonly>
                    to <INPUT type="text" name="meetingDateTo" size="12" value="<?php echo $meetingDateTo; ?>" readonly></TD>
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
                  </TD>
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
                  $_msg3 = "<B>審査者のコメントへの対応を選択し「送信」を押します。</B><BR>";
                  $_msg3 .= $_msg;
                  echo $_msg3;
                }
                ?>
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <?php
              $_msg = "<TR>\n";
              $_msg .= "<TD width='80%' align='left' valign='top' class='hpb-cnt-tb-cell2'>";
                if ($_errorFlag) {
                  $_msg .= "---";
                } elseif ($statusCode < 32) {
                  $_msg .= "　　審査が未終了の為、処理は進められません";
                } else {
                  $_attribute = "";
                  if (empty($statusTime33))
                    $_msg .= "　<INPUT type='checkbox' name='action[]' value='chk1'>審査1を完了(->33)　　";
                  $_attribute = "";
                  if (empty($statusTime42))
                    $_msg .= "　<INPUT type='checkbox' name='action[]' value='chk2'>審査2を完了(->42)　　";
                  if (!empty($statusTime33) && !empty($statusTime42))
                    $_msg .= "　　審査手続きは完了しています";
//                  $_msg .= "<INPUT type='checkbox' name='action[]' value='chk3'".$_attribute.">審査手続き完了(->52)";
                }
              $_msg .= "</TD>\n";
              $_msg .= "</TR>\n";
              echo $_msg;
              ?>
              </TBODY>
            </TABLE>
            <BR>
            <BR>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="bottom" class="hpb-dp-tb4-cell9">
                  審査完了時に記録に残すコメント/特記などがあれば入力し「送信」ボタンを押します。
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <?php
                if ($_errorFlag) {
                  $_msg2 = "---";
                  $_attribute = "disabled";
                } elseif (!empty($statusTime32) || !empty($statusTime34)) {
                  $_msg2 = $closeNote;
                  $_attribute = "";
                } else {
                  $_msg2 = "　　**審査手続きが未完了の為、入力はできません**";
                  $_attribute = "disabled";
                }
                ?>
                <TD align='left' valign='top' class='hpb-cnt-tb-cell2'>
                  <TEXTAREA name='closeNote' rows='8' cols='78' <?php echo $_attribute ?>><?php echo $_msg2 ?></TEXTAREA></TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="right" valign="top" class="hpb-dp-tb4-cell9">
                  <INPUT type="hidden" name="currentRow" value="<?php echo $cRow ?>">
                  <INPUT type="hidden" name="statusCode" value="<?php echo $statusCode ?>">
                  <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                  <INPUT type="hidden" name="backDisplay" value="<?php echo $backDisplay ?>">
                  <INPUT type="hidden" name="statusCodeShow" value="<?php echo $statusCodeShow ?>">
                  <INPUT type="hidden" name="fiscalYear" value="<?php echo $fiscalYear ?>">
                  <INPUT type="hidden" name="OrderDisplay" value="<?php echo $OrderDisplay ?>">
                  <INPUT type="hidden" name="reviewerEmail" value="<?php echo $reviewerEmail ?>">
                  <INPUT type="submit" name="do" value="　送信　"<?php echo $_attribute2; ?>>
                </TD>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                  <?php
                  if ($_staffOnly) {
                    switch ($backDisplay) {
                      case 1:
                        $_msg = "　中止し前画面に戻る　";
                        $_codename = "location.href='./showupByStatus.php?sCS=".$statusCodeShow."'";
                        break;
                      case 2:
                        $_msg = "　中止し前画面に戻る　";
                        $_codename = "location.href='./summarizeByYear.php?so=".$_staffOnly."&fy=".$fiscalYear."&od=".$OrderDisplay."'";
                        break;
                      default:
                        $_msg = "　中止し管理に戻る　";
                        $_codename = "location.href='./staff_only.php'";
                    } 
                  } else {
                    $_msg = "ホームに戻る";
                    $_codename = "'http://www.prc.tsukuba.ac.jp/papercheck/'";
                  }
                  ?>
                  <INPUT type="button" name="cancel" value="<?php echo $_msg ?>" onclick="location.href=<?php echo $_codename ?>">
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            </FORM>
            <BR>
            <BR>
            
            <FORM method="post" name="" action="./_mailFromStaff.php";>
              <INPUT type="hidden" name="entryNo" value="<?php echo $entryNo ?>">
              <INPUT type="hidden" name="currentRow" value="<?php echo $cRow ?>">
              <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-lb-lb1">
              <TBODY>
              <TR><TD>
                <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
                  <TBODY>
                  <TR>
                    <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                      処理状況に関わらずメール送信をそれぞれに行えます。
                      <?php
                      if (!empty($mailCnt) && $mailCnt !== 0) {
                      ?>
                      　　　　　　　　
                      <A href=javascript:window.open("./displaySentMail.php?cR=<?php echo $cRow ?>","_sub3","resizable=yes,width=760,height=600");void(0);>過去メールの表示</A>
                      <?php
                      }
                      ?>
                    </TD>
                  </TR>
                  </TBODY>
                </TABLE>
              </TD></TR>
              <TR><TD>
              <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
                  <TBODY>
                  <?php
                  $_msg = "<TR>\n";
                  $_msg .= "<TD align='left' valign='top' class='hpb-cnt-tb-cell2'>";
                  $_msg .= "<TEXTAREA name='mailBody1' rows='10' cols='78'>";
                  $_msg .= $requester." 様、\n\n";
                  $_msg .= "　外部発表審査について、第一段審査は終了しました。\n";
                  $_msg .= "会議の１週間前にはマイクロ波調整室にポスターを掲示してください。\n";
                  $_msg .= "会議前のRMにおいて発表をお願いします。\n";
                  $_msg .= "第二段審査を行います。\n\n";
                  $_msg .= "".$staffJname."\n\n";
                  $_msg .= "　申請対象　http://www.prc.tsukuba.ac.jp/papercheck/displayForm.php?id=".$entryNo."&uid=".$requesterEmail."\n";
                  $_msg .= "</TEXTAREA></TD>\n";
                  $_msg .= "</TR>\n";
                  $_msg .= "<TR>\n";
                  $_msg .= "<TD align='left' valign='center' class='hpb-cnt-tb-cell2'>";
                  $_msg .= "　　<INPUT type='submit' name='do' value=' 申請者へ送信 '></TD>\n";
                  $_msg .= "<INPUT type='hidden' name='mailTo1' value='".$requesterEmail."'></TD>\n";
                  $_msg .= "<INPUT type='hidden' name='mailSubject1' value='"."外部発表審査 (". $entryNo." on ".date('Y/m/d',strtotime($entryDate)).")'></TD>\n";
                  $_msg .= "</TR>\n";
                  echo $_msg;
                  ?>
                  </TBODY>
                </TABLE>
                <BR>
                <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
                  <TBODY>
                  <?php
                  $_msg = "<TR>\n";
                  $_msg .= "<TD align='left' valign='top' class='hpb-cnt-tb-cell2'>";
                  $_msg .= "<TEXTAREA name='mailBody2' rows='10' cols='78'>";
                  $_msg .= $reviewerJname." 先生、\n\n";
                  $_msg .= "\n\n\n\n\n";
                  $_msg .= "".$staffJname."\n\n";
                  $_msg .= "　審査対象　http://www.prc.tsukuba.ac.jp/papercheck/rv/reviewComment.php?id=".$entryNo."\n";
                  $_msg .= "</TEXTAREA></TD>\n";
                  $_msg .= "</TR>\n";
                  $_msg .= "<TR>\n";
                  $_msg .= "<TD align='left' valign='center' class='hpb-cnt-tb-cell2'>";
                  $_msg .= "　　<INPUT type='submit' name='do' value=' 審査者へ送信 '></TD>\n";
                  $_msg .= "<INPUT type='hidden' name='mailTo2' value='".$reviewerEmail."'></TD>\n";
                  $_msg .= "<INPUT type='hidden' name='mailSubject2' value='"."外部発表審査 (". $entryNo." by ".$requester.")'></TD>\n";
                  $_msg .= "</TR>\n";
                  echo $_msg;
                  ?>
                  </TBODY>
                </TABLE>
                
                <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
                  <TBODY>
                  <TR>
                    <TD align="left" valign="bottom" class="hpb-dp-tb4-cell9">
                      それぞれのメールに指導教員等をCcとして加える場合、該当者をチェックします。
                    </TD>
                  </TR>
                  </TBODY>
                </TABLE>
                <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1" >
                  <TBODY>
                  <TR>
                    <TD height="65" valign="middle" class="hpb-cnt-tb-cell2">
                    <?php
                    $excelfilename = 'EntrySheet.xlsx';
                    $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
                    $reader = new XlsxReader;
                    $excel = $reader->load($excelfilepath);
                    
                    $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
                    $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
                    
                    $sRow_reviewer = intval($ws1->getCell('B8')->getValue());
                    
                    $_row = $sRow_reviewer;
                    $_reviewer = $ws1->getCell('B'.$_row)->getValue();
                    $_str = "";
                    while ($_reviewer != "eol" ) {
                      list($_reviewerJname, $_reviewerEname, $_reviewerEmail, $_reviewerActive) = explode("!", $_reviewer);
                      
                      if ($_reviewerEname != "nakashma") {                        // 期間限定の条件 ######  2of2
                        if ($_row !==  $sRow_reviewer)
                          $_str .= ",";
                        
                        $_str .= $_reviewerJname;
                      }
                      
                      if ($_row >= 1000 ) {
                        break;
                      } else {
                        $_row++;
                        $_reviewer = $ws1->getCell('B'.$_row)->getValue();
                      }
                    }
                    
                    $reviewer = explode(",", $_str);
/*
echo "_str=(".$_str.")<br>";
var_dump($reviewer);
*/
                    for ($ii=1; $ii <= sizeof($reviewer); $ii++) {
                      if (($ii-1)%6 == 0)
                        $_str = "　";
                      else
                        $_str = "";
                      $_str .= "<INPUT type='checkbox' name='mail_cc[]' value='". $reviewer[$ii-1] ."'>" . $reviewer[$ii-1] . "先生";
                      if ($ii%6 == 0)
                        $_str .= "<BR>";
                      echo $_str . "\n";
                    }
                    $st_reviewer = implode(",", $reviewer);
                    ?>
                  </TD>
                </TR>
                </TBODY>
              </TABLE>
                </TD></TR>
              </TBODY>
            </TABLE>
            <BR>
            
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