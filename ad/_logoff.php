<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<TITLE>PRC_外部発表審査(管理)</TITLE>
</HEAD>

<BODY>

<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");
  
  
  echo "このコードは完了していません！<br>";
  //
  //  アルゴリズムの再検討が必要
  //
  //  以下のcgi処理ができるか？
    /* nph-logout.cgi
    #!/usr/bin/perl
    print <<EOF;
    HTTP/1.0 401 Unauthorized
    WWW-Authenticate: Basic Realm="valid users only"
    Content-Type: text/html
    
    <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
    <HTML><HEAD><TITLE>401 Authorization Required</TITLE></HEAD>
    <BODY>
    <H1>Authorization Required</H1>
    </BODY>
    </HTML>
    EOF
    */
  
  
/*
  $file = dirname( __FILE__ ) . "/.htpass_ad";
  $newfile = dirname( __FILE__ ) . "/.htpass_ad_org";
  
echo "$file<br>";
echo "$newfile<br>";
  
  $ID = "bp";
  $Passwd = "bprb";
  
  $cmd = "/usr/bin/htpasswd ";
  
  
  if (rename($file, $newfile)) {
    
    if (copy($newfile, $file)) {
      
      if (chmod($file, 0646)) {
        $cmd_upd = $cmd . "-m -b ./.htpass_ad " . $ID . " " . $Passwd;
        $cmd_upd .= " 2>&1";
        exec($cmd_upd, $output, $return_var);
        echo "パスワードの変更ができました<br>";
        
var_dump($output);
        
        // Sub-window で _staff_Only.php を表示する　　パスワード入力で　キャンセル　する　　　画面を閉じる
        // この画面に戻り　閉じる
      
      
      
      } else {
        echo "パーミッションの設定が既定の値ではありませんでした。";
      }
    } else {
      echo "コピーができません<br>";
    }
  } else {
    echo "リネームができません<br>";
  }
*/


?>


</BODY>
</HTML>
