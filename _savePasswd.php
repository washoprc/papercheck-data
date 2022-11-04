<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<TITLE>PRC_外部発表審査(申請)</TITLE>
</HEAD>

<BODY>
<?php
// PhpSpreadsheet ライブラリー
require_once "./ad/phpspreadsheet/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

// var_dump($_POST);

$userID = $_POST['userID'];
$Passwd = $_POST['Passwd'];
$newPasswd = $_POST['newPasswd'];
  
  
  $_staffOnly = 1;
  
  $excelfilename = 'Requesters.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/ad/data/' . $excelfilename;
  $reader = new XlsxReader;
  $excel = $reader->load($excelfilepath);
  $writer = new Xlsx($excel);
  
  $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
  $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
  
  $sRow = intval($ws1->getCell('B2')->getValue());
  
  
  
  // ユーザIDと新旧パスワードの確認
  
  $_errorNo = 0;
  if (!empty($userID)) {
    $_row = $sRow;
    $_userID = $ws2->getCell('C'.$_row)->getValue();
    while ($_userID != "eol") {
      
      if (!strcasecmp($userID,$_userID)) {
        $_link = $ws2->getCell('I'.$_row)->getValue();
        if ($_link == "Reviewer") {
          $_errorNo = 8;
          break;
        }
      }
      
      if ($_row >= 1000) {
        break;
      } else {
        $_row++;
        $_userID = $ws2->getCell('C'.$_row)->getValue();
      }
    }
  }
  
  if ($_errorNo !== 8) {
    
    if (empty($userID))
      $_errorNo = 1;                    // ユーザIDの入力なし
      
    elseif (empty($Passwd))
      $_errorNo = 2;                    // 現パスワードの入力なし
      
    elseif (empty($newPasswd))
      $_errorNo = 3;                    // 新パスワードの入力なし
      
    elseif (!strcmp($Passwd,$newPasswd))
      $_errorNo = 4;                    // 現パスワードと新パスワードが同じ
      
    else {
      
      $_errorNo = 5;            // ユーザIDの登録なし (申請の記録なし)
      $_row = $sRow;
      $_userID = $ws2->getCell('C'.$_row)->getValue();
      while ($_userID != "eol") {
      
// echo "compare uID: [".strcasecmp($userID,$_userID)."] (".$userID.")vs(".$_userID.")<br>";
        
        if (!strcasecmp($userID,$_userID)) {
          $_errorNo = 0;
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
      
      if ($_errorNo == 0 ) {
        $_hash_Passwd = $ws2->getCell('E'.$cRow)->getValue();
        
// echo "compare: [".strcmp(crypt($Passwd,$_hash_Passwd),$_hash_Passwd)."] (".crypt($Passwd,$_hash_Passwd).")vs(".$_hash_Passwd.")<br>";
        
        if (strcmp(crypt($Passwd,$_hash_Passwd),$_hash_Passwd))
          $_errorNo = 6;            // 現パスワードの不一致
          
        else {
          
          // データの保存(書込み)
          $hash_newPasswd = crypt($newPasswd);
          $rightNow = date('Y/m/d H:i:s');
          
          $ws2->setCellValue('E'.$cRow,$hash_newPasswd);
          $ws2->setCellValue('H'.$cRow,$rightNow);
          
          $writer->save( $excelfilepath );
          
        }
      }
    }
  }
  
  
  if ($_errorNo == 0)
    $_msg = "location: ./_connectUserid.php?uid=".$userID."&eno=".$_errorNo."&so=".$_staffOnly."&bD=2";
  else
    $_msg = "location: ./changePasswd.php?uid=".$userID."&eno=".$_errorNo;
  
// echo $_msg . "<br>";
  
  header($_msg);
  exit;

?>
</BODY>
</HTML>
