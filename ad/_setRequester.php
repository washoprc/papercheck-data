<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<TITLE>PRC_外部発表審査(管理)</TITLE>
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

$taskcode = $_POST['taskcode'];
$cRow = $_POST['cRow'];
$requester = $_POST['requester'];
$requesterEmail = $_POST['requesterEmail'];
$_staffOnly = $_POST['so'];
  
  
  $excelfilename = 'Requesters.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
  $reader = new XlsxReader;
  $excel = $reader->load($excelfilepath);
  $writer = new Xlsx($excel);
  
  $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
  $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
  
/*
$obj1 = $ws1->toArray( null, true, true, true );
var_dump($obj1);
echo "<br/>";
*/
  
  $sRow = intval($ws1->getCell('B2')->getValue());
  $eRow = intval($ws1->getCell('B3')->getValue());
  
  $rightNow = date('Y/m/d H:i:s');
  
  $_errorNo = 0;        // 正常に処理を終了
  switch ((int)$taskcode) {
    case 0:  // 追加
      $_row = $sRow;
      $_userID = $ws2->getCell('C'.$_row)->getValue();
      while ($_userID != "eol") {
        
        if (!strcasecmp($requesterEmail,$_userID)) {
          break;
        }
        
        if ($_row >= 1000) {
          break;
        } else {
          $_row++;
          $_userID = $ws2->getCell('C'.$_row)->getValue();
        }
      }
      $cRow = $_row;
      
      if ($eRow == ($cRow-1) ) {
        $Passwd = substr($requesterEmail,0,strpos($requesterEmail,'@'));           // 申請履歴参照用の仮パスワード
        $hash_Passwd = crypt($Passwd);
        
        $ws2->setCellValue('B'.$cRow,$requester);
        $ws2->setCellValue('C'.$cRow,$requesterEmail);
        $ws2->setCellValue('E'.$cRow,$hash_Passwd);
        $ws2->setCellValue('G'.$cRow,$rightNow);
        $ws2->setCellValue('H'.$cRow,$rightNow);
        $ws2->setCellValue('C'.++$cRow,'eol');
        $ws1->setCellValue('B3',--$cRow);
        
        $writer->save( $excelfilepath );
      }
      break;
      
    case 1:  // 修正
      $ws2->setCellValue('B'.$cRow,$requester);
      $ws2->setCellValue('C'.$cRow,$requesterEmail);
      $ws2->setCellValue('H'.$cRow,$rightNow);
      
      $writer->save( $excelfilepath );
      break;
      
    case 2:  // 削除
      $ws2->removeRow($cRow,1);
      $ws1->setCellValue('B3',--$eRow);
      
      $writer->save( $excelfilepath );
      break;
      
    case 3:  // PSW初期化
      $_link = $ws2->getCell('I'.$cRow)->getValue();
      if ($_link == "Reviewer") {
        $_errorNo = 1;        // 審査者のPWS変更は不可
      } else {
        $Passwd = substr($requesterEmail,0,strpos($requesterEmail,'@'));           // 申請履歴参照用の仮パスワード
        $hash_Passwd = crypt($Passwd);
        $ws2->setCellValue('E'.$cRow,$hash_Passwd);
        $ws2->setCellValue('H'.$cRow,$rightNow);
        
        $writer->save( $excelfilepath );
      }
      break;
      
    default:
      
  }
  
  
  $_msg = "location: ../_connectUserid.php?so=".$_staffOnly."&eno=".$_errorNo."&bD=4";
  header($_msg);
  exit;

?>


</BODY>
</HTML>
