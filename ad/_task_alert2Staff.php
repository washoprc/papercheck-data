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

/*
var_dump($_GET);
*/

$_schedule = $_GET['sc'];
  
  
  $justnow = date("Y/m/d H:i:s");
  
  include_once( dirname( __FILE__ ) . '/../functions.php' );
  
  
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
  
  
  $sRow = intval($ws1->getCell('B2')->getValue());
  
  $_row = $sRow;
  $_entryNo = $ws2->getCell('B'.$_row)->getValue();
  $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
  
  while (isset($_entryNo) && $_entryNo != "eol") {
    
    // 条件 --> Status(10 || 32 || 34) & 通常処理(0) & 各処理日から２日経過(-2)
    if ((10 == $_statuscode || 32 == $_statuscode || 34 == $_statuscode) && (0 == intval(substr($_entryNo,3,1)))) {
      
      if (10 == $_statuscode) {
        $_entryDate = $ws2->getCell('AB'.$_row)->getValue();
        $daydiff1 = (strtotime($_entryDate)-time())/(3600*24);
// echo "entryNo:(".$_entryNo."), now:(".$justnow."), entryDate=(".$_entryDate.")(".$daydiff1.")<br>";
        
      } elseif (32 == $_statuscode) {
        $_statusTime32 = $ws2->getCell('AD'.$_row)->getValue();
        $daydiff1 = (strtotime($_statusTime32)-time())/(3600*24);
// echo "entryNo:(".$_entryNo."), now:(".$justnow."), statusTime32=(".$_statusTime32.")(".$daydiff1.")<br>";
        
      } elseif (34 == $_statuscode) {
        $_statusTime34 = $ws2->getCell('AI'.$_row)->getValue();
        $daydiff1 = (strtotime($_statusTime34)-time())/(3600*24);
// echo "entryNo:(".$_entryNo."), now:(".$justnow."), statusTime34=(".$_statusTime34.")(".$daydiff1.")<br>";
        
      } else {
        $daydiff1 =15;
      }
      
      if ($daydiff1 < -2) {
        
        $staffJName = $ws2->getCell('L'.$_row)->getValue();
        $staffEmail = $ws2->getCell('N'.$_row)->getValue();
        
        $entry[] = array($staffEmail, $staffJName, $_entryNo, $_statuscode, 0);
      }
    }
    
    if ($_row >= 1000) {
      break;
      
    } else {
      $_row++;
      $_entryNo = $ws2->getCell('B'.$_row)->getValue();
      $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
    }
  }
/*
var_dump($entry);
*/
  
  
  
  $programStartYear = 2016;
  
  $fiscalyear = $programStartYear;
  $_row = $sRow;
  $_entryNo = $ws2->getCell('B'.$_row)->getValue();
  $_FiscalYear_Meeting = intval($ws2->getCell('X'.$_row)->getValue());
  
  while ($_entryNo != "eol" ) {
    if ('0' == substr($_entryNo,3,1)) {
      if ($fiscalyear < $_FiscalYear_Meeting) {
        $fiscalyear = $_FiscalYear_Meeting;
      }
    }
    if ($_row >= 1000 ) {
      break;
    } else {
      $_row++;
      $_entryNo = $ws2->getCell('B'.$_row)->getValue();
      $_FiscalYear_Meeting = intval($ws2->getCell('X'.$_row)->getValue());
    }
  }
  
  
  
  $limiter = 0;
  while (true) {
    $i = 0;
    $j = 0;
    $entry_pre = "";
    $staffEmail0 = "";
    
    while (!empty($entry[$i][0])) {
      if ($entry[$i][4] == 0) {
        if (empty($staffEmail0)) {
// echo "最初：(".$entry[$i][2]."), (".$entry[$i][3].")<br>";
          $staffJname0 = $entry[$i][1];
          $staffEmail0 = $entry[$i][0];
          $entryNo0[$j] = $entry[$i][2];
          $statuscode[$j] = $entry[$i][3];
          $entry_pre = $entry[$i][0];
          $entry[$i][4] = 1;
          $j++;
        } elseif ($entry[$i][0] == $entry_pre) {
// echo "追加：(".$entry[$i][2]."), (".$entry[$i][3].")<br>";
          $entryNo0[$j] = $entry[$i][2];
          $statuscode[$j] = $entry[$i][3];
          $entry[$i][4] = 1;
          $j++;
        }
      }
      
      $i++;
      
    }
    
    
    if (empty($staffEmail0) || $limiter > 1000) {
      break;
      
    } else {
      
      $testingEmail = $ws1->getCell('B6')->getValue();            // 試行時のメール送付先アドレス
      
      $to = $staffEmail0;
//      $to = $testingEmail;                                          // ### Mail ###
      
      $subject = "外部発表審査　(処理催促)";
      $header = "From: " . "apache@prc.tsukuba.ac.jp";
//      $header .= "\nBcc: " . $testingEmail;                       // ##########
      
      $body = $staffJname0 . " 先生、\n";
      $body .= "\n　このメールは、外部発表審査の手続きにより作成された次の申請に対して";
      $body .= "\n幹事による処理が２日以上経過していることをお知らせするものです。";
      $body .= "\n作業が完了されるまでこのメールは定期に送信されます。";
      $body .= "\n";
      
      $body .= "\n　以下のURLをクリックして「審査者の設定」を行ってください。";
      $l = 0;
      for ($k=0; $k < $j; $k++) {
        if ($statuscode[$k] == 10)
          $body .= "\n" . ++$l . ".　http://www.prc.tsukuba.ac.jp/papercheck/ad/assignReviewer.php?id=" . $entryNo0[$k] . "&so=1&bD=6\n";
      }
      if ($l == 0)
        $body .= "\n　　-- 該当なし --";
      $body .= "\n";
      
      $body .= "\n　以下のURLをクリックして「審査終了」を確認してください。";
      $l = 0;
      for ($k=0; $k < $j; $k++) {
        if ($statuscode[$k] !== 10)
          $body .= "\n" . ++$l . ".　http://www.prc.tsukuba.ac.jp/papercheck/ad/conductSteps.php?id=" . $entryNo0[$k] . "&so=1&bD=2&fy=". getThisFiscal('Y') . "&od=A2\n";
      }
      if ($l == 0)
        $body .= "\n　　-- 該当なし --";
      $body .= "\n";
      
      $body .= "\n　「年度利用一覧」の表示には以下のURLをクリックします。";
      $body .= "\n　　http://www.prc.tsukuba.ac.jp/papercheck/ad/summarizeByYear.php?so=1&fy=" . $fiscalyear . "&od=A2\n";
      $body .= "\n以上";
      $body .= "\n";
      
      // メール送信の実行
      if(mb_send_mail($to,$subject,$body,$header)) {
        $_msg = "Sucessed!";
      } else {
        $_msg = "Failed in mail sending";
      }
      echo date('H:i:s')."  メール送信実行 (" . $_msg . ")<br>";
      
      $limiter++;
      $staffEmail0 = "";
    }
  }
  
  
  
  if ($_schedule) {
    $_msg = "<br>";
    $_msg .= "幹事への催促メールの送信処理が行われました。<br>";
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
