<?php
// セッション開始！
session_start();
?>
 
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<body>
 
<?php
// $_SESSIONのデータを出力
echo $_SESSION['sdata1'] ."<br />";
echo $_SESSION['sdata2'] ."<br />";
print_r( $_SESSION['sdata3'] );
 
var_dump($_SESSION);


// $_SESSIONのデータ削除
$_SESSION = array();
 
// セッションを破棄
// session_destroy();
?>
 
</body>
</html>

