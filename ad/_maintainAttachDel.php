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

//  var_dump($_GET);

$attachment = $_GET['tf'];
$filename = $_GET['fn'];
  
  
  $filepath = dirname( __FILE__ ) . '/data/' . $attachment . '/' . $filename;
//  echo "DELETE::(".$filepath.")<br>";
  
  if (file_exists($filepath)) {
    unlink($filepath);
  } else {
    echo "ファイルが存在しません (".$filepath.")<br>";
  }
  
  $_str = "<SCRIPT type='text/JavaScript'>window.open('./maintainAttach.php?tf=".$attachment."','_sub2')</SCRIPT>";
  echo $_str;
  exit;

?>


<BR>　この処理(_maintainAttachDel)は終了しました<BR>
<BR>
<FORM>
<INPUT type="button" name="" value="　戻る　" onclick="<?php echo $_str ?>">
</FORM>
<BR>

</BODY>
</HTML>