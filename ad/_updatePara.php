<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(管理)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>

<BODY>

<?php
// PhpSpreadsheet ライブラリー
require_once "phpspreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

/*
var_dump($_POST);
*/

$staffJname = $_POST['staffJname'];
$staffEname = $_POST['staffEname'];
$staffEmail = $_POST['staffEmail'];
$testingEmail = $_POST['testingEmail'];
$_action = $_POST['_action'];
  
  
  if (!strcasecmp($_action,"Update")) {
    $excelfilename = 'EntrySheet.xlsx';
    $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
    $reader = new XlsxReader;
    $excel = $reader->load($excelfilepath);
    $writer = new Xlsx($excel);
    
    $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
    
/*
$obj1 = $ws1->toArray( null, true, true, true );
var_dump($obj1);
echo "<br/>";
*/
    
    $staff = $ws1->getCell('B4')->getValue();
    list($staffJname_old, $staffEname_old, $staffEmail_old) = explode("!", $staff);
    
// echo "更新前:(".$staffEname_old."), 更新後:(".$staffEname.")<br>";
    
    if (strcasecmp($staffEname_old,$staffEname)) {
      // LoginIDの更新
      $_msg = "　英語の幹事名はLoginIDとして利用しています。<br>";
      $_msg .= "今後、旧IDに替えて新IDを使用してください。<br>";
      $_msg .= "新IDと同じ文字が既定値パスワードに設定されていますので<br>";
      $_msg .= "速やかに更新してください。　新ID:(".$staffEname.")<br>";
      echo $_msg;
      
      $cmd = "/usr/bin/htpasswd ";
      $cmd_apd = $cmd . "-m -b .htpass_ad " . $staffEname . " " . $staffEname;
      $cmd_apd .= " 2>&1";
      exec($cmd_apd, $output, $return_var);
      $cmd_del = $cmd . "-D .htpass_ad " . $staffEname_old;
      $cmd_del .= " 2>&1";
      exec($cmd_del, $output, $return_var);
/*
var_dump($output);
*/
    }
    
    // 書込みするデータ
    $staff = $staffJname . "!" . $staffEname . "!" . $staffEmail;
    $testingEmail = $testingEmail;
    
// echo "staff=(".$staff.")<br>";
    
    // データの保存(書込み)
    $ws1->setCellValue('B'.'4',$staff);
    $ws1->setCellValue('B'.'6',$testingEmail);
    
    $writer->save( $excelfilepath );
    
    echo date('H:i:s')."  書込み終了<br>";
    
  } else {
    if (!strcasecmp($_action,"test1")) {
      $_msg = "幹事メールアドレス";
      $to = $staffEmail;
    } else {
      $_msg = "試行用メールアドレス";
      $to = $testingEmail;
    }
    
    // 登録するアドレスを確認する為のメールを作成
    $subject = "TEST MAIL from 外部発表審査";
    $header = "From: " . "apache@prc.tsukuba.ac.jp";
    
    $body = "\n";
    $body .= "　このメールは、設定されたメールアドレスの確認の為に送信しています。\n";
    $body .= "\n";
    $body .= "　　送信元:　　　「外部発表審査」\n";
    $body .= "　　アドレス用途:　" . $_msg . " \n";
    $body .= "　　送信先:　　　(" . $to . ") \n";
    $body .= "\n";
    $body .= "　心当たりのない場合には、破棄してください。\n";
    $body .= "\n";
    
// echo "Body=(".$body.")<br>";
    
    // メール送信の実行
    if(mb_send_mail($to,$subject,$body,$header)) {
      $_msg = "Sucessed!";
    } else {
      $_msg = "Faile in mail sending";
    }
    
    echo date('H:i:s')."  メール送信実行 (".$_msg.")<br>";
    
  }
?>


<BR>
<FORM method="post" action="./staff_only.php">
  <INPUT type="submit" name="" value="　管理に戻る　">
</FORM>
<BR>

</BODY>
</HTML>
