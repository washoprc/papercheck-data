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
$reviewerJname = $_POST['reviewerJname'];
$reviewerEname = $_POST['reviewerEname'];
$reviewerEname_old = $_POST['reviewerEname_old'];
$reviewerEmail = $_POST['reviewerEmail'];
$reviewerActive = $_POST['reviewerActive'];
$reviewerActive_old = $_POST['reviewerActive_old'];
$_staffOnly = $_POST['so'];

if (is_numeric($reviewerActive))
  $reviewerActive = (int)$reviewerActive;
else
  $reviewerActive = 0;
  
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
  
  $sRow_reviewer = intval($ws1->getCell('B8')->getValue());
  $numOfRow = intval($ws1->getCell('B9')->getValue());
  
  $cmd = "/usr/bin/htpasswd ";
  $rightNow = date('Y/m/d H:i:s');
  
  $_errorNo = 0;        // 正常に処理を終了
  switch ((int)$taskcode) {
    case 0:  // 追加
      $newRow = $sRow_reviewer + $numOfRow;
      $_line = $reviewerJname . "!" . $reviewerEname . "!" . $reviewerEmail . "!" . $reviewerActive;
      
      $Passwd = $reviewerEname;                                  // 申請履歴参照用の仮パスワード
      $hash_Passwd = crypt($Passwd);
      
      $ws1->insertNewRowBefore($newRow, 1);
      $ws1->setCellValue('B'.$newRow,$_line);
      $ws1->setCellValue('C'.$newRow,$hash_Passwd);
      $ws1->setCellValue('E'.$newRow,$rightNow);
      (int)$numOfRow++;
      $ws1->setCellValue('B9',$numOfRow);
      $writer->save( $excelfilepath );
      
      $cmd_apd = $cmd . "-m -b ../rv/.htpass_rv " . $reviewerEname . " " . $Passwd;
      $cmd_apd .= " 2>&1";
      exec($cmd_apd, $output, $return_var);
      break;
      
    case 1:  // 修正
      $_line = $reviewerJname . "!" . $reviewerEname . "!" . $reviewerEmail . "!" . $reviewerActive;
      $Passwd = $reviewerEname;                                  // 申請履歴参照用の仮パスワード
      $hash_Passwd = crypt($Passwd);
      
      $ws1->setCellValue('B'.$cRow,$_line);
      $ws1->setCellValue('C'.$cRow,$hash_Passwd);
      $ws1->setCellValue('E'.$cRow,$rightNow);
      $writer->save( $excelfilepath );
                                         // 氏名、Name、メールアドレスのいずれかの修正の場合もパスワードは初期化する
      if ($reviewerActive == $reviewerActive_old) {
        $cmd_upd = $cmd . "-m -b ../rv/.htpass_rv " . $reviewerEname . " " . $Passwd;
        $cmd_upd .= " 2>&1";
        exec($cmd_upd, $output, $return_var);
        
        if (strcasecmp($reviewerEname, $reviewerEname_old)) {
          $cmd_del = $cmd . "-D ../rv/.htpass_rv " . $reviewerEname_old;
          $cmd_del .= " 2>&1";
          exec($cmd_del, $output, $return_var);
        }
      }
      break;
      
    case 2:  // 削除
      $ws1->removeRow($cRow,1);
      (int)$numOfRow--;
      $ws1->setCellValue('B9',$numOfRow);
      $writer->save( $excelfilepath );
      
      $cmd_del = $cmd . "-D ../rv/.htpass_rv " . $reviewerEname_old;
      $cmd_del .= " 2>&1";
      exec($cmd_del, $output, $return_var);
// echo "cmd_del=(".$cmd_del.")<br>";

      break;
      
    case 3:  // PSW初期化
      $Passwd = $reviewerEname;                                  // 申請履歴参照用の仮パスワード
      $hash_Passwd = crypt($Passwd);
      
      $ws1->setCellValue('C'.$cRow,$hash_Passwd);
      $ws1->setCellValue('E'.$cRow,$rightNow);
      $writer->save( $excelfilepath );
      
      $cmd_ini = $cmd . "-m -b ../rv/.htpass_rv " . $reviewerEname . " " . $Passwd;
      $cmd_ini .= " 2>&1";
      exec($cmd_ini, $output, $return_var);
      break;
      
    default:
      
  }

/*
var_dump($output);
*/
  
  
  $_msg = "location: ../_connectUserid.php?so=".$_staffOnly."&eno=".$_errorNo."&bD=5";
  header($_msg);
  exit;

?>


</BODY>
</HTML>
