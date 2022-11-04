<?php


//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");


  $to = "n3o3ka3ya3.1357@gmail.com";
  
  $subject = "センシングシステム";
  
  $header = "From: " . "apache@prc.tsukuba.ac.jp";
  $header .= "\r\nBcc: " . "okazaki@prc.tsukuba.ac.jp";
  
  $body = "岡崎さん、\n";
  $body .= "\n　こんにちは。このメールは、Raspberrypiからメール送信のテストです。";
  $body .= "\n";
  
  // メール送信の実行
  if(mb_send_mail($to,$subject,$body,$header)) {
    $_msg = "Sucessed!";
  } else {
    $_msg = "Failed in mail sending";
  }
  echo date('H:i:s')."  メール送信実行 (" . $_msg . ")<br>";
      


?>
