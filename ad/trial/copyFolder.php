<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(判断/判定)</TITLE>
</HEAD>

<BODY>

<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");


$folder = "1498455482";

$src = "../data/" . $folder;
$dst = "../../rv/data/" . $folder;


echo "src=(".$src.")<br>";
echo "dst=(".$dst.")<br>";

  mkdir($dst);
  $handle = opendir($src);
  while(false !== ($file = readdir($handle))) {
    if (($file != '.') && ($file != '..')) {
      if ( is_dir($src . '/' . $file) ) {
        recurse_copy($src . '/' . $file,$dst . '/' . $file);
      } else {
        copy($src . '/' . $file,$dst . '/' . $file);
      }
    }
  }
  closedir($handle);

?>


</BODY>
</HTML>