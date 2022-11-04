<?php
session_start();
?>
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>
<?php
$_SESSION['sdata1'] = 123;
$_SESSION['sdata2'] = "hello world";
$_SESSION['sdata3'] = array(123, "hello world", "PHP入門");

echo "セッションデータを追加しました。<br>";
?>

<p>こちらにアクセスし、セッションデータを出力してみよう。<br>
 --> 「<a href="session-2.php">セッションデータの出力</a>」</p>
 
</BODY>
</HTML>