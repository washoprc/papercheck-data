<?php
echo <<<DOC
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(管理)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>
<BODY>
DOC;
?>

<?php
// PhpSpreadsheet ライブラリー
require_once "phpspreadsheet/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

//  var_dump($_GET);

$_schedule = $_GET['sc'];
  
  
  $justnow = date("Y/m/d H:i:s");
  
  $excelfilename = 'EntrySheet.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
  $reader = new XlsxReader;
  $excel = $reader->load($excelfilepath);
  
  $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
  $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
  
/*
$obj1 = $ws1->toArray( null, true, true, true );
var_dump($obj1);
echo "<br/>";
$obj2 = $ws2->toArray( null, true, true, true );
var_dump($obj2);
echo "<br/>";
*/
  
  
  
  $_row = intval($ws1->getCell('B2')->getValue());
  $_entryNo = $ws2->getCell('B'.$_row)->getValue();
  $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
  $_meetingDate = $ws2->getCell('H'.$_row)->getValue();
//  $_statusTime22 = $ws2->getCell('AC'.$_row)->getValue();
  
  while (isset($_entryNo) && $_entryNo != "eol") {
    
    $daydiff1 = (int)((strtotime($_meetingDate)-strtotime($justnow))/(3600*24)+1);
//    $daydiff2 = (strtotime($_statusTime22)-strtotime($justnow))/(3600*24);
// echo "entryNo:(".$_entryNo."), now:(".$justnow."), meetingDate=(".$_meetingDate.")(".$daydiff1."), statusTime22=(".$_statusTime22.")(".$daydiff2.")<br>";
    
    // 条件 --> 審査が未完了(33) & 通常処理(0) & 会議開始日2週間前(14)
    if ((33 == $_statuscode ) && (0 == intval(substr($_entryNo,3,1))) && ($daydiff1 == 14)) {
        
      $requester = $ws2->getCell('C'.$_row)->getValue();
      $requesterEmail = $ws2->getCell('D'.$_row)->getValue();
      
      $entry[] = array($requesterEmail, $requester, $_entryNo, $_meetingDate, 0);
    }
    
    if ($_row >= 1000) {
      break;
      
    } else {
      $_row++;
      $_entryNo = $ws2->getCell('B'.$_row)->getValue();
      $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
      $_meetingDate = $ws2->getCell('H'.$_row)->getValue();
//      $_statusTime22 = $ws2->getCell('AC'.$_row)->getValue();
    }
  }
/*
var_dump($entry);
*/
  
  
  
  $limiter = 0;
  while (true) {
    $i = 0;
    $j = 0;
    $entry_pre = "";
    $requesterEmail0 = "";
    
    while (!empty($entry[$i][0])) {
      if ($entry[$i][4] == 0) {
        if (empty($requesterEmail0)) {
// echo "最初：(".$entry[$i][2]."), (".$entry[$i][3].")<br>";
          $requester0 = $entry[$i][1];
          $requesterEmail0 = $entry[$i][0];
          $entryNo0[$j] = $entry[$i][2];
          $meetingDate0[$j] = $entry[$i][3];
          $entry_pre = $entry[$i][0];
          $entry[$i][4] = 1;
          $j++;
        } elseif ($entry[$i][0] == $entry_pre) {
// echo "追加：(".$entry[$i][2]."), (".$entry[$i][3].")<br>";
          $entryNo0[$j] = $entry[$i][2];
          $meetingDate0[$j] = $entry[$i][3];
          $entry[$i][4] = 1;
          $j++;
        }
      }
      
      $i++;
      
    }
    
    
    if (empty($requesterEmail0) || $limiter > 1000) {
      break;
      
    } else {
      
      $testingEmail = $ws1->getCell('B6')->getValue();            // 試行時のメール送付先アドレス
      
      $to = $requesterEmail0;
//      $to = $testingEmail;                                          // ### Mail ###
      
      $subject = "外部発表審査　(発表予告)";
      $header = "From: " . "apache@prc.tsukuba.ac.jp";
//      $header .= "\nBcc: " . $testingEmail;                       // ##########
      
      $body = $requester0 . " 様、\n";
      $body .= "\n　外部発表審査の手続きで申請された会議日の２週間前になりました。";
      $body .= "\nＲＭでの発表準備またはマイクロ波調整室でのポスター掲示を行い";
      $body .= "\n審査を受ける準備をお願いします。";
      $body .= "\n";
      
      $body .= "\n　対象となる申請は以下のURLでの履歴参照で確認してください。";
      $body .= "\n    http://www.prc.tsukuba.ac.jp/papercheck/index.html";
      $body .= "\nその際に入力するユーザIDは申請のメールアドレスまたパスワードの";
      $body .= "\n初期値はそのメールアドレスのユーザ名となっています。";
      
      $body .= "\n";
      $body .= "\n以上";
      $body .= "\n";
// echo "Body=(".$body.")<br>";
      
      // メール送信の実行
      if(mb_send_mail($to,$subject,$body,$header)) {
        $_msg = "Sucessed!";
      } else {
        $_msg = "Failed in mail sending";
      }
      echo date('H:i:s')."  メール送信実行 (" . $_msg . ")<br>";
      
      $limiter++;
      $reviewerEmail0 = "";
    }
  }
  
  
  
  if ($_schedule) {
    $_msg = "<br>";
    $_msg .= "申請者への発表予告メールの送信処理が行われました。(" . $limiter . " 件)<br>";
    $_msg .= "<br>　　";
    $_msg .= "<INPUT type='button' value='管理に戻る' onclick=location.href='staff_only.php'>";
    $_msg .= "<br>";
    echo $_msg;
    
  } else {
    $_msg = "<script>window.close()</script>";
    echo $_msg;
    
  }

?>

</BODY>
</HTML>
