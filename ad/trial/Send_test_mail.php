<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<TITLE>試行メール送信</TITLE>
</HEAD>
<BODY>

<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");
    
    
    $to = "okazaki@prc.tsukuba.ac.jp";
    
    $subject = "TEST MAIL by mb_send_mail()";
    
    $header = "From: " . "apache@prc.tsukuba.ac.jp";
    
    $body = "メール送信機能の試行中です。\n";
    
    
    if(mb_send_mail($to,$subject,$body,$header)) {
      $_msg = "Sucessed!";
      
    } else {
      $_msg = "Faile in mail sending";
      
    }
    
    echo date('H:i:s')."  メール送信実行 (".$_msg.")<br>";
    
?>

</BODY>
</HTML>
