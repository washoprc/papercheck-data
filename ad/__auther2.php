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


  $cmd = "htpasswd 2>&1";
  $cmd = "/usr/bin/htpasswd -m -b .htpass_ad okazaki2 okazaki 2>&1";
//  $output = shell_exec($cmd);

  exec($cmd, $output);


var_dump($output);

echo "After:<br>";
echo "　user=(".$_SERVER['PHP_AUTH_USER']."), ";

echo "user's pw=(".$_SERVER['PHP_AUTH_PW'].")<br>";


  if (chmod(".htpass_ad", 0664)) {
    echo "success!";
  } else {
    echo "Fault";
  }                              ;   // 1:execute  2: write   4:read
?>

</BODY>
</HTML>