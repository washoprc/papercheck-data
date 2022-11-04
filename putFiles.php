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

$tmp_folder = $_GET['tf'];


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
                  申請には３件の資料ファイルを添付できます。 選択後、[添付する]ボタンを押します。<BR>
                  　　(Officeファイル, テキストファイル, PDF, など)
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            <FORM method="POST" action="./_keepFiles.php?tf=<?php echo $tmp_folder ?>" enctype="multipart/form-data">
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0">
              <TBODY>
              <TR height="30" valign="middle">
                <TD colspan="2">1. <INPUT type="file" name="selectedfile[]"></TD>
              </TR>
              <TR height="30" valign="middle">
                <TD colspan="2">2. <INPUT type="file" name="selectedfile[]"></TD>
              </TR>
              <TR height="30" valign="middle">
                <TD colspan="2">3. <INPUT type="file" name="selectedfile[]"></TD>
              </TR>
              <TR height="60" valign="bottom">
                <TD width="110" align="center" class="hpb-dp-tb4-cell9">
                  <INPUT type ="submit" value="添付する"></TD>
                <TD align="left" class="hpb-dp-tb4-cell9">
                  <INPUT type="button" name="" value="閉じる" onclick="window.close();"></TD>
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