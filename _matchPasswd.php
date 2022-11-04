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

//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

// var_dump($_POST);

$userID = $_POST['userID'];
$Passwd = $_POST['Passwd'];
  
  
  // ユーザIDとパスワードの入力確認
  if (empty($userID))
    $_errorNo = 1;            // ユーザIDの入力なし
    
  elseif (empty($Passwd))
    $_errorNo = 2;            // パスワードの入力なし
    
  else {
    
    $excelfilename = 'Requesters.xlsx';
    $excelfilepath = dirname( __FILE__ ) . '/ad/data/' . $excelfilename;
    $reader = new XlsxReader;
    $excel = $reader->load($excelfilepath);
    
    $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
    $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
    
    $sRow = intval($ws1->getCell('B2')->getValue());
    
    $_errorNo = 3;            // ユーザIDの登録なし (申請の記録なし)
    $_row = $sRow;
    $_userID = $ws2->getCell('C'.$_row)->getValue();
    while ($_userID != "eol") {
      
// echo "compare: [".strcasecmp($userID,$_userID)."] (".$userID.")vs(".$_userID.")<br>";
      
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
      
      // パスワード確認
      $_hash_Passwd = $ws2->getCell('E'.$cRow)->getValue();
      
// echo "compare: [".strcmp(crypt($Passwd,$_hash_Passwd),$_hash_Passwd)."] (".crypt($Passwd,$_hash_Passwd).")vs(".$_hash_Passwd.")<br>";
      
      if (strcmp(crypt($Passwd,$_hash_Passwd),$_hash_Passwd))
        $_errorNo = 4;            // パスワードの不一致
    
    }
    
  }
  
  
  if ($_errorNo==0)
    $_msg = "location: ./index_Form.php?uid=".$userID;
  else
    $_msg = "location: ./checkPasswd.php?uid=".$userID."&eno=".$_errorNo;
  
// echo $_msg . "<br>";
  
  header($_msg);
  exit;

?>
</BODY>
</HTML>