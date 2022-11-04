<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>DATE FORMAT</TITLE>
</HEAD>

<BODY>
<?php

var_dump($_SERVER);

echo "Before:<br>";
echo "　user=(".$_SERVER['PHP_AUTH_USER']."), ";

echo "user's pw=(".$_SERVER['PHP_AUTH_PW'].")<br>";


  $cmd = "/user/bin/htpasswd.exe -m -b .htpass okazaki2 bprb";
  exec($cmd, $output, $return_var);
  

echo "After:<br>";
echo "　user=(".$_SERVER['PHP_AUTH_USER']."), ";

echo "user's pw=(".$_SERVER['PHP_AUTH_PW'].")<br>";

var_dump($_SERVER);

?>

</BODY>
</HTML>