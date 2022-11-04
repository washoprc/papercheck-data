<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(申請)</TITLE>
<LINK href="./hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
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

// var_dump($_GET);

$fromNo = $_GET['fn'];
$entryNo = $_GET['en'];

$userID = $_GET['uid'];
$_errorNo = $_GET['eno'];

$backDisplay = $_GET['bD'];
if (!isset($backDisplay))
  $backDisplay = 0;

$_staffOnly = $_GET['so'];
  
  
  // 審査者の読込み
  $excelfilename = 'EntrySheet.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/ad/data/' . $excelfilename;
  $reader = new XlsxReader;
  $excel = $reader->load($excelfilepath);
  
  $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
  
  $sRow_reviewer = intval($ws1->getCell('B8')->getValue());
  
  $_row = $sRow_reviewer;
  $_reviewer = $ws1->getCell('B'.$_row)->getValue();
  while ($_reviewer != "eol") {
    list($_reviewerJname, $_reviewerEname, $_reviewerEmail, $_reviewerActive) = explode("!", $_reviewer);
    
    if ((int)$_reviewerActive) {
      $hash_Passwd = $ws1->getCell('C'.$_row)->getValue();
      $_reviewers[$_reviewerEmail] = $hash_Passwd;
    }
    
    if ($_row >= 1000) {
      break;
    } else {
      $_row++;
      $_reviewer = $ws1->getCell('B'.$_row)->getValue();;
    }
  }
  $cRow_reviewer = $_row;
  
/*
foreach($_reviewers as $reviewerEmail=>$Passwd) {
  echo "$reviewerEmail...$Passwd<br>";
}
echo "<br><br>";
*/
  
  // 申請者ID(Eメール)と審査者Eメールの連携
  
  $rightNow = date('Y/m/d H:i:s');
  
  $excelfilename = 'Requesters.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/ad/data/' . $excelfilename;
  $reader = new XlsxReader;
  $excel = $reader->load($excelfilepath);
  $writer = new Xlsx($excel);
  
  $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
  $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
  
  $sRow = intval($ws1->getCell('B2')->getValue());
  
  $_row = $sRow;
  $_userID = $ws2->getCell('C'.$_row)->getValue();
  while ($_userID != "eol") {
    $_link = "";
    
    foreach($_reviewers as $reviewerEmail=>$Passwd) {
      if (!strcasecmp($_userID,$reviewerEmail)) {
// echo "$reviewerEmail...$Passwd<br>";
        $_Passwd = $Passwd;                                    // 審査者でなくなった場合の申請者パスワードは変更しない
        $_link = "Reviewer";
        break;
      }
    }  
    if ($_link == "Reviewer") {
      $ws2->setCellValue('E'.$_row,$_Passwd);
      $ws2->setCellValue('H'.$_row,$rightNow);
    }
    $ws2->setCellValue('I'.$_row,$_link);
    $writer->save( $excelfilepath );
    
    if ($_row >= 1000) {
      break;
    } else {
      $_row++;
      $_userID = $ws2->getCell('C'.$_row)->getValue();
    }
  }
  
// echo date('H:i:s')."  処理完了<br>";
  
  
  switch ((int)$backDisplay) {
    case 0:                   // 管理に戻る
      $_msg = "location: ./ad/staff_only.php";
      break;
      
    case 1:                        //  --> saveForm -->  申請に戻る
      $_msg = "location: ./_selector.php?fn=".$fromNo."&so=".$_staffOnly."&en=".$entryNo;
      break;
      
    case 2:                        //  --> savePasswd -->  申請履歴に戻る
      $_msg = "location: ./index_Form.php?uid=".$userID."&eno=".$_errorNo;
      break;
      
    case 3:                        //  --> savePasswd_rv -->  審査一覧に戻る
      $_msg = "location: ./rv/index_Comment.php";
      break;
      
    case 4:                        //  --> _setRequester -->  申請者管理に戻る
      $_msg = "location: ./ad/maintainRequester.php?so=".$_staffOnly."&eno=".$_errorNo;
      break;
      
    case 5:                        //  --> _setReviewer -->  審査者管理に戻る
      $_msg = "location: ./ad/maintainReviewer.php?so=".$_staffOnly."&eno=".$_errorNo;
      break;
      
    default:
      $_fromNo = 9;
      $_msg = "location: ../_selector.php?fn=".$_fromNo."&so=".$_staffOnly."&en=00-00000";
  }
  
// echo "msg=(".$_msg.")<br>";
  header($_msg);
  exit;

?>


<BR>　この処理(_connectUserID)は終了しました<BR>
<BR>
<FORM>
  <?php
  if ($_staffOnly) {
    $_msg = "　管理に戻る　";
    $_codename = "location.href='./ad/staff_only.php'";
  } else {
    $_msg = "　ホームに戻る　";
    $_codename = "location.href='http://www.prc.tsukuba.ac.jp/papercheck/'";
  }
  ?>
  <INPUT type="button" name="" value="<?php echo $_msg ?>" onclick="<?php echo $_codename ?>">
</FORM>
<BR>

</BODY>
</HTML>
