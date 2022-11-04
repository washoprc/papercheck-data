<?php
echo <<<DOC1
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>WHO IS AUTHER</TITLE>
</HEAD>

<BODY>
DOC1;

 
var_dump($_SERVER);

echo "user=(".$_SERVER['PHP_AUTH_USER'].")<br>";

echo "user's pw=(".$_SERVER['PHP_AUTH_PW'].")<br>";



echo <<<DOC2
</BODY>
</HTML>
DOC2;
?>