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
//  var_dump($_POST);

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
                <TD width="100" class="hpb-lb-tb1-cell4"> </TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
                <TR>
                  <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                    ユーザIDは申請時に入力したメールアドレスを利用します。<BR>
                    パスワード更新は各自で適時に行います。<BR>
                    <BR>
                    新パスワードには、現パスワードと同じものは使えません。
                  </TD>
                </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            <?php
            $_msg = "";
            if (!empty($_errorNo)) {
              switch ((int)$_errorNo) {
                case 0:
                  $_msg .= "<BR>　<FONT color='green'>パスワードは更新されました</FONT>";
                  break;
                case 1:
                  $_msg .= "<BR>　<FONT color='red'>ユーザIDが入力されていません</FONT>";
                  break;
                case 2:
                  $_msg .= "<BR>　<FONT color='red'>現パスワードが入力されていません</FONT>";
                  break;
                case 3:
                  $_msg .= "<BR>　<FONT color='red'>新パスワードが入力されていません</FONT>";
                  break;
                case 4:
                  $_msg .= "<BR>　<FONT color='red'>現パスワードと新パスワードが同じです</FONT>";
                  break;
                case 5:
                  $_msg .= "<BR>　<FONT color='red'>ユーザIDが正しくありません</FONT>";
                  break;
                case 6:
                  $_msg .= "<BR>　<FONT color='red'>現パスワードが正しくありません</FONT>";
                  break;
                case 8:
                  $_msg .= "<BR>　<FONT color='red'>審査画面と連携の為、変更は <A href=./rv/index_Comment.php>審査一覧</A> からお願いします</FONT>";
                  break;
                default:
                  $_msg .= "";
              }
            }
            ?>
            
            <FORM method="post" action="./_savePasswd.php">
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                  現パスワードと新たなパスワードを入力して、[送信]をクリックしてください。
                  <?php echo $_msg ?></TD>
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <TABLE width="80%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <TD width="20%" height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">ユーザID</TD>
                <TD width="80%" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="" size="40" value="<?php echo $userID ?>" disabled></TD>
                  <INPUT type="hidden" name="userID" value="<?php echo $userID ?>"
              </TR>
              <TR>
                <TD width="20%" height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">現パスワード</TD>
                <TD width="80%" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="Passwd" size="40" value="" placeholder="********" ></TD>
              </TR>
              <TR>
                <TD width="20%" height="30" align="left" valign="center" class="hpb-cnt-tb-cell1">新パスワード</TD>
                <TD width="80%" align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="newPasswd" size="40" value="" placeholder="********"></TD>
              </TR>
              </TBODY>
            </TABLE>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
                 <TR>
                  <TD align="right" valign="top" class="hpb-dp-tb4-cell9">
                    <INPUT type="submit" name="" value="　設定　"<?php echo $_attribute2; ?>></TD>
                  <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                    <INPUT type="button" name="" value="申請履歴に戻る" onclick="location.href='./index_Form.php?uid=<?php echo $userID ?>'"></TD>
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