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

include_once( dirname( __FILE__ ) . '/../functions.php' );

$_schedule = $_GET['sc'];
  
  
  $excelfilename = 'EntrySheet.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
  $reader = new XlsxReader;
  $excel = $reader->load($excelfilepath);
  
  $textfilename = 'currentTally.txt';
  $textfilepath = dirname( __FILE__ ) . '/yearly/' . $textfilename;
  
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
  
  $perform = "// " . date('Y/m/d H:i:s') . "\r\n";               // 集計日
  $perform .= "// A line is formed as Year ! Entry ! Working ! Approval ! Disapproval ! Pending ! Summation\r\n";
  $perform .= "\r\n";
  
  $sRow = intval($ws1->getCell('B2')->getValue());
  
  $programStartYear = 2016;
  $fiscalyear = $programStartYear;
  $_row = $sRow;
  $_entryNo = $ws2->getCell('B'.$_row)->getValue();
  $_fiscalyear = $ws2->getCell('X'.$_row)->getValue();
  while (isset($_entryNo) && $_entryNo != "eol") {
    if ('0' == substr($_entryNo,3,1)) {
      if ($fiscalyear < $_fiscalyear) {
        $fiscalyear = $_fiscalyear;
      }
    }
    if ($_row >= 1000) {
      break;
    } else {
      $_row++;
      $_entryNo = $ws2->getCell('B'.$_row)->getValue();
      $_fiscalyear = $ws2->getCell('X'.$_row)->getValue();
    }
  }
  
  // $fiscalyear = getThisFiscal('Y');                  // 申請番号基準の場合  -- 当年を使いまた $_entryNo を使用
  
  while (true) {
    
    $event = $counter1 = $counter2[0] = $counter2[1] = $counter2[2] = $counter2[3] = 0;
    
    $_row = $sRow;
    $_entryNo = $ws2->getCell('B'.$_row)->getValue();
    $_FiscalYear_Meeting = $ws2->getCell('X'.$_row)->getValue();
    $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
    while (isset($_entryNo) && $_entryNo != "eol") {
      
      if ('0' == substr($_entryNo,3,1) && $fiscalyear == $_FiscalYear_Meeting) {
        
        $event++;
        switch ($_statuscode) {
          case 22:
          case 32:
          case 33:
          case 34:
            $counter1++;
            break;
            
          case 42:
            $counter2[0]++;
            switch ($ws2->getCell('V'.$_row)->getValue()) {
              case "承認":
                $counter2[1]++;
                break;
              case "不承認";
                $counter2[2]++;
                break;
              case "保留":
                $counter2[3]++;
                break;
              default:
            }
            break;
            
          default:
            
        }
      }
      
      if ($_row >= 1000) {
        break;
      } else {
        $_row++;
        $_entryNo = $ws2->getCell('B'.$_row)->getValue();
        $_FiscalYear_Meeting = $ws2->getCell('X'.$_row)->getValue();
        $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
      }
    }
    
    $perform .= $fiscalyear . "!" . $event . "!" . $counter1 . "!" . $counter2[1] . "!" . $counter2[2] . "!" . $counter2[3] . "!" . $counter2[0] . "\r\n";
// echo "perform=(".$perform.")<br>";
    
    $fiscalyear--;
    if ($fiscalyear < $programStartYear ) {
      
//      echo "検索終了<br>";
      
      break;
    }
  }
  
  file_put_contents($textfilepath, $perform);
  
  
  
  if ($_schedule) {
    $_msg = "<br>";
    $_msg .= "「利用概況」のファイル (./ad/yearly/currentTally.txt)は更新されました。<br>";
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
