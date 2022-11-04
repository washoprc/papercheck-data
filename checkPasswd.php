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

//  var_dump($_GET);

$userID = $_GET['uid'];
$_errorNo = $_GET['eno'];

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
                    自身の申請履歴を参照する際には、ユーザID/パスワードで認証を行います。<BR>
                    ユーザIDは申請時に入力したメールアドレスを利用します。<BR>
                    <BR>
                    パスワードは、適時に更新するようにお願いします。<BR>
                  </TD>
                </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            <?php
            $_msg = "";
            if (!empty($_errorNo) || (int)$_errorNo !== 0) {
              switch ((int)$_errorNo) {
                case 1:
                  $_msg .= "　<BR><FONT color='red'>ユーザIDが入力されていません</FONT>";
                  break;
                case 2:
                  $_msg .= "　<BR><FONT color='red'>パスワードが入力されていません</FONT>";
                  break;
                case 3:
                  $_msg .= "　<BR><FONT color='red'>ユーザIDが登録されていません</FONT>";
                  break;
                case 4:
                  $_msg .= "　<BR><FONT color='red'>パスワードが正しくありません</FONT>";
                  break;
                default:
                  $_msg .= "";
              }
            }
            ?>
            
            <FORM method="post" action="./_matchPasswd.php">
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                  ユーザIDとパスワードを入力して、[確認]をクリックしてください。
                  <?php echo $_msg ?></TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <TABLE width="80%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <TD width="20%" height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">ユーザID</TD>
                <TD width="80%" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="userID" size="40" value="<?php echo $userID ?>"></TD>
              </TR>
              <TR>
                <TD width="20%" height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">パスワード</TD>
                <TD width="80%" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="password" name="Passwd" size="40" value="" placeholder="********" ></TD>
              </TR>
              </TBODY>
            </TABLE>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
                 <TR>
                  <TD align="right" valign="top" class="hpb-dp-tb4-cell9">
                    <INPUT type="submit" name="" value="　確認　"<?php echo $_attribute2; ?>></TD>
                  <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                    <INPUT type="button" name="" value="ホームに戻る" onclick="location.href='./index.html'"></TD>
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