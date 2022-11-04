<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");


// セッション開始！
// session_start();

var_dump($_SERVER);


// $_SESSIONのデータ削除
$_SERVER = array();
 
// セッションを破棄
// session_destroy();


echo "user=(".$_SERVER['PHP_AUTH_USER'].")<br>";
?>

