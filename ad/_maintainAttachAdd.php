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
//  var_dump($_FILES);

$attachment = $_GET['tf'];
  
  
  $uploads_dir = dirname( __FILE__ ) . '/data/' . $attachment .'/';
  
  $ii = 0;
  foreach ($_FILES["selectedfile"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
      if (!file_exists($uploads_dir)) {
        if (mkdir($uploads_dir, 0777)) {
          chmod($uploads_dir, 0777);
        } else {
          echo "添付資料用フォルダーの作成に失敗しました (".$attachment.")";
        }
      }
      $tmp_name = $_FILES["selectedfile"]["tmp_name"][$key];
      $uploads_file = $uploads_dir . $_FILES["selectedfile"]["name"][$key];
      $uploads_file = str_replace(' ','_',$uploads_file);                   // ファイル名中の半角スペースをアンダースコアに置換える
      move_uploaded_file($tmp_name, $uploads_file);
      
    } else {
// echo "error-->(".$_FILES["selectedfile"]["error"][$key].")<br>";
      $ii++;
      if ($ii == 3) {
        $_str = "<SCRIPT type='text/JavaScript'>window.history.back(-1);</SCRIPT>";
        echo $_str;
        exit;
      }
    }
  }
  
  
  $_str = "<SCRIPT type='text/JavaScript'>window.open('./maintainAttach.php?tf=".$attachment."','_sub2')</SCRIPT>";
  echo $_str;
  exit;

?>


<BR>　この処理(_maintainAttachAdd)は終了しました<BR>
<BR>
<FORM>
<INPUT type="button" name="" value="　戻る　" onclick="<?php echo $_str ?>">
</FORM>
<BR>

</BODY>
</HTML>