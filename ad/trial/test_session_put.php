<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(申請)</TITLE>
</HEAD>

<BODY>
<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");


var_dump($_POST);
var_dump($_SESSION);


session_start();



echo $_SESSION['folderID'];


$_SESSION['folderID'] = "AAA";
 
echo "別画面でセッション変数に値を設定します。<br>";
$_str = "<A href='javascript:void(0)' onclick=window.open('./test_session_get.php','sub1','width=300,height=200')>確認画面を開く<br></A>";
echo $_str;

?>
</BODY>
</HTML>