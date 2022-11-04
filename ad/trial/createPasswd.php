<?php

$id = 'okazaki';
$passwd = 'passwd';

echo "1. " . crypt($passwd)."<br>";

echo "2. " . substr(crypt($id), -2) . "<br>";

  // saltは固定しなくてもシステムで使われる頭年桁の文字となる  crypt($passwd)でok!
  // このsaltは$passwdで作成したハッシュ化文字列を使うと生成される文字列は同じになる
echo "3. " . crypt($passwd, '$1$iIUkyZ0m$wZa3UAmupEkVIHOQnsh760') . "\n";

?>

