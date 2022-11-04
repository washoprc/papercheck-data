<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>WAHT IS AUTH</TITLE>
</HEAD>

<BODY>

<?php
 
var_dump($_SERVER);

echo "user=(".$_SERVER['PHP_AUTH_USER'].")<br>";

echo "user's pw=(".$_SERVER['PHP_AUTH_PW'].")<br>";

?>

</BODY>
</HTML>