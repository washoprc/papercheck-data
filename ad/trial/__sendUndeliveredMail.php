<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(申請)</TITLE>
<LINK href="./hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>

<BODY>
<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");



  $to2 = 'okazaki-error@prc.tsukuba.ac.jp';
  
  $subject = "外部発表審査　(不正メールアドレス)";
  $header = "From: " . "apache@pec.tsukuba.ac.jp";
  
  
  $body = "\n";
  $body .= "\n　このメールはテスト送信です。";
  $body .= "\n";
  $body .= "\n　送信日時:　" . date('Y/m/d H:i:s');
  $body .= "\n";
  
  
  // メール送信の実行
  if(mb_send_mail($to,$subject,$body,$header)) {
    $_msg = "Sucessed!";
  } else {
    $_msg = "Failed in mail sending";
  }
echo date('H:i:s')."  メール送信終了 (".$_msg.")<br>";
  

?>


</BODY>
</HTML>
