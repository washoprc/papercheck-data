<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(判断/判定)</TITLE>
<SCRIPT type="text/javascript">
<!--
function wopen(fp) {
	window.open(fp, "", "width=420,height=594");
}
// -->
</SCRIPT>
<LINK href="../../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>

<BODY>

<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");
?>

<BR><BR>
<TABLE width="600" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
  <TBODY>
  <TR>
    
    <TD width="140" align="left" valign="center" rowspan="3" class="hpb-cnt-tb-cell1">資料ファイル</TD>
    <TD height="60" align="left" valign="top" class="hpb-cnt-tb-cell2">
    
    <?php
    $attachment = "1498455482";
    $directory = "../data/".$attachment;
    $files = scandir($directory);
    foreach($files as $file) {
      if ($file != "." && $file != "..") {
        $_str = "<P><A href=javascript:wopen('".$directory."/".$file."');void(0); title='".substr($file,strrpos($file,'.')+1)."'>".$file."</A></P>\n";
        echo $_str;
      }
    }
    ?>
    
    </TD>
  </TR>
  </TBODY>
</TABLE>
<BR>

</BODY>
</HTML>