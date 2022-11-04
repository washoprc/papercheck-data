<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(審査)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>

<BODY>
<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

/*
var_dump($_GET);
var_dump($_POST);
*/

$_staffOnly = $_GET['so'];
$_errorNo = $_GET['eno'];
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
                    審査者毎に扱う情報は限定されており、その為ユーザID/パスワードが設定されています。<BR>
                    パスワードの更新は各自で行います。ユーザーIDを変更する際には幹事にお知らせください。<BR>
                    <BR>
                    新パスワードには、空文字、現パスワードと同じものは使えません。
                  </TD>
                </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            <FORM method="post" action="./_savePasswd_rv.php">
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                  現パスワードと新たなパスワードを入力して、[送信]をクリックしてください。
                  <?php
                  if (!empty($_errorNo) || (int)$_errorNo !== 0) {
                    $_msg = "<br><FONT color=red>";
                    switch ((int)$_errorNo) {
                      case 1:
                        $_msg .= "現パスワードが入力されていません";
                        break;
                      case 2:
                        $_msg .= "新パスワードが入力されていません";
                        break;
                      case 3:
                        $_msg .= "現パスワードと新パスワードが同じです";
                        break;
                      case 4:
                        $_msg .= "現パスワードが正しくありません";
                        break;
                      case 5:
                        $_msg .= "このユーザIDは教員リストにありません";
                        break;
                      default:
                        $_msg = "管理者に問い合わせてください";
                    }
                    echo $_msg;
                  }
                  ?>
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <TABLE width="80%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <TD width="20%" height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">ユーザID</TD>
                <TD width="80%" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="userID" size="30" value="<?php echo $_loginID ?>" disabled></TD>
              </TR>
              <TR>
                <TD width="20%" height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">現パスワード</TD>
                <TD width="80%" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="currentPasswd" size="30" value="" placeholder="********" ></TD>
              </TR>

              <TR>
                <TD height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">新パスワード</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="newPasswd" size="30" value="" placeholder="********"></TD>
              </TR>
              </TBODY>
            </TABLE>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
                 <TR>
                  <TD align="right" valign="top" class="hpb-dp-tb4-cell9">
                    <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                    <INPUT type="submit" name="" value="　送信　"<?php echo $_attribute2; ?>></TD>
                  <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                    <?php
                    if ($_staffOnly) {
                      $_msg = "　中止し管理に戻る　";
                      $_codename = "'../ad/staff_only.php'";
                    } else {
                      $_msg = "審査一覧に戻る";
                      $_codename = "'./index_Comment.php'";
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