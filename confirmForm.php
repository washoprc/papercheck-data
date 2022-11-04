<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(申請)</TITLE>
<LINK href="./hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>

<BODY>
<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

/* ---
SESSION_START();
--- */

//  var_dump($_SESSION);
//  var_dump($_POST);

$requester = $_POST['requester'];
$requesterEmail = $_POST['requesterEmail'];
$eventTitle = $_POST['eventTitle'];
$author = $_POST['author'];
$meetingTitle = $_POST['meetingTitle'];
$meetingDate = $_POST['meetingDate'];
$meetingDateTo = $_POST['meetingDateTo'];
$abstract = $_POST['abstract'];
if (isset($_POST['mail_cc']) && is_array($_POST['mail_cc']))
  $mail_cc = $_POST['mail_cc'];
$attachedFile_wo = $_POST['attachedFile_wo'];
if ($_POST['attachedFile_wo'] != "有")
  $attachedFile_wo = null;
$attachment = $_POST['attachment'];
$reviewer = $_POST['reviewer'];
$_id = $_POST['_id'];
$_staffOnly = $_POST['so'];

$chk =array();
$reviewer = explode(',', $reviewer);
for ($ii=0; $ii < sizeof($mail_cc); $ii++) {
  for ($jj=0; $jj < sizeof($reviewer); $jj++) {
    if ($mail_cc[$ii] == $reviewer[$jj]) {
      $chk[$jj] = true;
    }
  }
}
$mail_cc = implode(",", $mail_cc);

/* ---
if (!isset($_SESSION['folderID'])) {
  $_SESSION['folderID'] = $old_tmp_folderID = "-";
} else {
  $old_tmp_folderID = $_SESSION['folderID'];
}
--- */
$textfilename = 't_folderID.txt';
$textfilepath = dirname( __FILE__ ) . '/ad/data/tmp/' . $textfilename;
if (is_file($textfilepath)) {
  $old_tmp_folderID = file_get_contents($textfilepath);
  unlink($textfilepath);
} else {
  $old_tmp_folderID = time();
}
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
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                入力された情報は次のようです。<BR>
                修正の必要が無ければ、[申請]をクリックしてください。<BR>
                <BR>
                情報は登録されたのち、審査手続きが開始されます。
                <?php
                $_msg = "";
                if (!strncasecmp(substr($_id,3,1),"1",1)) {
                  $_msg = "<FONT color='green'>　　** 試行中 **</FONT>";
                }
                echo $_msg;
                ?>
                <BR></TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            <?php
            $_attribute = " readonly";
            $_attribute2 = " disabled";
            ?>
            
            <FORM method="post" action="./_saveForm.php">
            
            <TABLE class="hpb-cnt-tb1" cellspacing="0" cellpadding="5" width="100%" border="0">
              <TBODY>
              <TR>
                <TD width="20%" align="left" valign="center" class="hpb-cnt-tb-cell1">申請者氏名</TD>
                <TD width="80%" align="left" valign="center" class="hpb-cnt-tb-cell2">
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
                  <TEXTAREA name="eventTitle" rows="3" cols="60"<?php echo $_attribute; ?>><?php echo $eventTitle; ?></TEXTAREA></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">著者</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="author" rows="4" cols="60"<?php echo $_attribute; ?>><?php echo $author; ?></TEXTAREA></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">学術誌/会議名 等</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="meetingTitle" rows="3" cols="60"<?php echo $_attribute; ?>><?php echo $meetingTitle; ?></TEXTAREA></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">会議開催期間</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  from <INPUT type="text" name="meetingDate" size="12" value="<?php echo $meetingDate; ?>"<?php echo $_attribute ?>>
                  to <INPUT type="text" name="meetingDateTo" size="12" value="<?php echo $meetingDateTo; ?>"<?php echo $_attribute ?>>　　書式例: 2017/03/28</TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">論文の要点</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="abstract" rows="10" cols="60"<?php echo $_attribute; ?>><?php echo $abstract; ?></TEXTAREA></TD>
              </TR>
              </TBODY>
            </TABLE>
            
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="bottom" class="hpb-dp-tb4-cell9">
                  以下のチェック者に申請通知メールをＣＣで送ります。
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1" >
              <TBODY>
              <TR>
                <TD height="65" valign="middle" class="hpb-cnt-tb-cell2">
                  <?php
                  for ($ii=1; $ii <= sizeof($reviewer); $ii++) {
                    if (($ii-1)%6 == 0)
                      $_str = "　";
                    else
                      $_str = "";
                    $_str .= "<INPUT type='checkbox' name='mail_cc[]' value='" . $reviewer[$ii-1] . "'";
                    if ($chk[$ii-1])
                      $_str .= " checked";
                    $_str .= $_attribute2 . ">" . $reviewer[$ii-1] . "先生";
                    if ($ii%6 == 0)
                      $_str .= "<BR>";
                    echo $_str . "\n";
                  }
                  ?>
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="bottom" class="hpb-dp-tb4-cell9">
                <?php
                if ($attachedFile_wo == '有')
                  echo "概要などの説明資料の添付には[添付]をクリックします。 (ファイル名には半角英数字のみ使用)";
                else
                  echo "以下のように概要などの説明資料の添付をしない設定になっています。";
                ?>
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <?php
                if ($attachedFile_wo == '有') {
                  $_str = "<TD width='80' valign='middle' class='hpb-cnt-tb-cell2'>";
                  $_str .= "　<INPUT type='button' name='' value='添付' onclick=window.open('./putFiles.php?tf=".time()."','_sub1','resizable=yes,width=780,height=380');>";
                  $_str .= "</TD>";
                  $_str .= "<TD align='left' valign='top' class='hpb-cnt-tb-cell2'>";
                  $directory = "./ad/data/tmp/".$old_tmp_folderID."/";
                  $filecount = 0;
                  $filename = array();
                  foreach(glob($directory . '*') as $file) {
                    $filename[$filecount] = basename($file);
                    $_str .= $filecount+1 . ". " . $filename[$filecount] . "<br>";
                    $filecount++;
                  }
                  if (!$filecount)
                    $_str .= "　( ファイルはまだ添付されていません。)";
                  $_str .= "</TD>"; 
                  echo $_str;
                } else {
                  $_str = "<TD valign='middle' class='hpb-cnt-tb-cell2'>";
                  $_str .= "<INPUT type='checkbox' name='' value='' " . $_attribute2 . ">　添付する資料ファイルがある";
                  $_str .= "</TD>";
                  echo $_str;
                }
                ?>
              </TR>
              </TBODY>
            </TABLE>
            
            
            <BR>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <?php
                if (isset($requester)) {
                ?>
                <TD align="right" valign="top" class="hpb-dp-tb4-cell9">
                  <INPUT type="submit" name="" value="　申請　"></TD>
                <TD align="center" valign="top" class="hpb-dp-tb4-cell9">
                  <INPUT type="button" name="" value="　修正　" onclick="history.back()"></TD>
                <?php
                } else {
                ?>
                <TD colspan="2" align="center" valign="top" class="hpb-dp-tb4-cell9">
                  <FONT color="red" >他のBrowserを利用してください　(システム不具合)</FONT></TD>
                <?php
                }
                ?>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                <?php
                if ($_staffOnly) {
                  $_msg = "　中止し管理に戻る　";
                  $_codename = "'./ad/staff_only.php'";
                } else {
                  $_msg = "ホームに戻る";
                  $_codename = "'http://www.prc.tsukuba.ac.jp/papercheck/'";
                }
                ?>
                <INPUT type="button" name="" value="<?php echo $_msg ?>" onclick="location.href=<?php echo $_codename ?>"></TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <?php
            $nowDate = date('Y/m/d H:i:s');
            $checkFile = $filename[0].$filename[1].$filename[2];
            if ($attachedFile_wo == '有' && $checkFile == '') {
              $statusCode = 8;
              $statusTime10 = null;
            } else {
              $statusCode = 10;
              $statusTime10 = $nowDate;
            }
            ?>
            
            <INPUT type="hidden" name="attachedFile_wo" value="<?php echo $attachedFile_wo ?>">
            <INPUT type="hidden" name="attachment" value="<?php echo $old_tmp_folderID ?>">
            <INPUT type="hidden" name="filename1" value="<?php echo $filename[0] ?>">
            <INPUT type="hidden" name="filename2" value="<?php echo $filename[1] ?>">
            <INPUT type="hidden" name="filename3" value="<?php echo $filename[2] ?>">
            <INPUT type="hidden" name="mail_cc" value="<?php echo $mail_cc ?>">
            <INPUT type="hidden" name="_id" value="<?php echo $_id ?>">
            <INPUT type="hidden" name="entryDate" value="<?php echo $nowDate ?>">
            <INPUT type="hidden" name="statusCode" value="<?php echo $statusCode ?>">
            <INPUT type="hidden" name="statusTime10" value="<?php echo $statusTime10 ?>">
            <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
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