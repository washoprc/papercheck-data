<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<TITLE>PRC_外部発表審査(審査)</TITLE>
</HEAD>

<BODY>

<?php
// PhpSpreadsheet ライブラリー
require_once "../ad/phpspreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

// var_dump($_POST);

$Passwd = $_POST['currentPasswd'];
$newPasswd = $_POST['newPasswd'];
$_staffOnly = $_POST['so'];
  
  
  $PHP_AUTH_USER = $_SERVER['PHP_AUTH_USER'];
  $PHP_AUTH_PW = $_SERVER['PHP_AUTH_PW'];
  
  
  if (empty($Passwd)) {
    $_errorNo = 1;                    // 現パスワードが入力されていません";
    
  } elseif (empty($newPasswd)) {
    $_errorNo = 2;                    // 新パスワードが入力されていません";
    
  } elseif (!strcmp($Passwd,$newPasswd)) {
    $_errorNo = 3;                    // 現パスワードと新パスワードが同じです";
    
  } elseif (strcmp($Passwd,$PHP_AUTH_PW)) {
    $_errorNo = 4;                    // 現パスワードが正しくありません";
    
  } else {
    $_errorNo = 5;                    // 処理を開始
    
    $excelfilename = 'EntrySheet.xlsx';
    $excelfilepath = dirname( __FILE__ ) . '/../ad/data/' . $excelfilename;
    $reader = new XlsxReader;
    $excel = $reader->load($excelfilepath);
    $writer = new Xlsx($excel);
    
    $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
    
    $sRow_reviewer = intval($ws1->getCell('B8')->getValue());
    
    $cmd = "/usr/bin/htpasswd ";
    $rightNow = date('Y/m/d H:i:s');
    
    $_row = $sRow_reviewer;
    $_reviewer = $ws1->getCell('B'.$_row)->getValue();
    while ($_reviewer != "eol" ) {
      
      list($_reviewerJname, $_reviewerEname, $_reviewerEmail, $_reviewerActive) = explode("!", $_reviewer);
      
// echo "(".$PHP_AUTH_USER.")...(".$_reviewerEname.")<br>";
      if (!strcasecmp($PHP_AUTH_USER, $_reviewerEname)) {
        
        $hash_Passwd = crypt($newPasswd);
        
        $ws1->setCellValue('C'.$_row,$hash_Passwd);
        $ws1->setCellValue('E'.$_row,$rightNow);
        $writer->save( $excelfilepath );
        
        $cmd_upd = $cmd . "-m -b .htpass_rv " . $PHP_AUTH_USER . " " . $newPasswd;
        $cmd_upd .= " 2>&1";
        exec($cmd_upd, $output, $return_var);
        
// var_dump($output);
        
        $_errorNo = 0;
        
        break;
      }
      
      if ($_row >= 1000) {
        break;
      } else {
        $_row++;
        $_reviewer = $ws1->getCell('B'.$_row)->getValue();
      }
    }
  }
  
// echo "_errorNo=(".$_errorNo.")<br>";
  
  
  if ($_errorNo == 0)
    $_msg = "location: ../_connectUserid.php?bD=3";
  else
    $_msg = "location: ./changePasswd_rv.php?eno=".$_errorNo;
  
// echo $_msg . "<br>";
  
  header($_msg);
  exit;

?>
</BODY>
</HTML>
