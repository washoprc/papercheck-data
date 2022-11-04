<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(管理)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>

<BODY>

<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

/*
var_dump($_POST);
*/

$staffEname = $_POST['staffEname'];
$staffPasswd = $_POST['staffPasswd'];
  
  
  $cmd = "/usr/bin/htpasswd ";
  $cmd_apd = $cmd . "-m -b .htpass_ad " . $staffEname . " " . $staffPasswd;
  $cmd_apd .= " 2>&1";
  exec($cmd_apd, $output, $return_var);
/*
var_dump($output);
*/
  
// echo date('H:i:s')."  書換え終了<br>";

?>

<BR>　情報の更新を完了しました。<BR>

<BR>
<FORM method="post" action="./staff_only.php">
  <INPUT type="submit" name="" value="　管理に戻る　">
</FORM>
<BR>

</BODY>
</HTML>
