<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(管理)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>

<BODY>
<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

//  var_dump($_GET);

$attachment = $_GET['tf'];
$_staffOnly = $_GET['so'];


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
//                    $_msg = "<A href='javascript:void(0)' onclick=location.href='./staff_only.php'>";
//                    $_msg .= "<FONT color='green'>* 管理 *</FONT></A>";
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
                  申請には３件の資料ファイルを添付できます。<BR>
                  　既登録ファイルの削除は[削除]ボタンで、追加添付はファイル選択し[追加]を押します。<BR>
                  　更新する場合には、[削除]した後に[追加]の操作をします。<BR>
                  作業を確定するために、前画面に戻った際に画面の[再読込み]を行います。
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb2">
              <TBODY>
                <?php
                $i = 0;
                $directory = "./data/".$attachment;
                $files = scandir($directory);
                foreach($files as $file) {
                  if ($file != "." && $file != "..") {
                    $_str = "<TR>\n<TD align='left' valign='top' class='hpb-cnt-tb-cell4'>\n";
                    $_str .= $i+1 . ". <INPUT type='button' value='削除' onclick=location.href='./_maintainAttachDel.php?tf=".$attachment."&fn=".$file."&so=" . $_staffOnly . "'>　";
                    $_str .= "<A href='".$directory."/".$file."' title='".substr($file,strrpos($file,'.')+1)."'>".$file."</A></TD>\n</TR>\n";
                    echo $_str;
                    $i++;
                  }
                }
                if (3-$i > 0) {
                  $_str = "<FORM method='POST' action='./_maintainAttachAdd.php?tf=" . $attachment . "&so=" . $_staffOnly . "' enctype='multipart/form-data'>\n";
                  for ($j=3-$i; $j>0; $j--) {
                    $_str .= "<TR>\n<TD align='left' valign='top' class='hpb-cnt-tb-cell4'>";
                    $_str .= $i+1 . ". <INPUT type='file' name='selectedfile[]'>";
                    $_str .= "</TD>\n</TR>\n";
                    $i++;
                  }
                  $_str .= "<TR>\n<TD width='110' align='left' class='hpb-dp-tb4-cell9'>　　<INPUT type ='submit' value='追加'>";
                  $_str .= "</TD>\n</TR>\n";
                  $_str .= "</FORM>\n";
                  echo $_str;
                }
                ?>
              </TBODY>
            </TABLE>
            
            <FORM>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0">
              <TBODY>
              <TR height="60" valign="bottom">
                <TD align="left" class="hpb-dp-tb4-cell9">
                  <INPUT type="button" name="" value="戻る" onclick="window.opener.location.reload();window.close(); return false;">
                    <FONT size="-1" color="red">　　作業を確定するために[戻る]ボタンで前画面に戻った際、[再読込み]を行います。</FONT></TD>
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