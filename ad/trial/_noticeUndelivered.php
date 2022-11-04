
<?php
function noticeUndelivered($entryNo,$errorMsg) {
  
  // PHPExcel ライブラリー
  include_once( dirname( __FILE__ ) . '/Classes/PHPExcel.php' );
  include_once( dirname( __FILE__ ) . '/Classes/PHPExcel/IOFactory.php' );
  
  $excelfilename = 'EntrySheet.xlsx';
  $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
  $reader = PHPExcel_IOFactory::createReader( 'Excel2007' );
  $excel = $reader->load( $excelfilepath );
  $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
  
  $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
  $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
  
  
  // 試行時のメール送付先アドレス
  $testingEmail = $ws1->getCell('B6')->getValue();
  
  
  switch intval(substr($errorMsg, 0, 2)) {
    case '1':
      $filenameError = "_saveReviewer.php";
      $msg = "**************";
      $msg .= substr($errorMsg,1);
      break;
      
    case '2':
      break;
      
    default:
  }
  
  
  // システム管理者に送信するメールを作成
  $to = $testingEmail;
  $subject = "外部発表審査　(メール送信エラー)";
  $header = "From: " . "apache@pec.tsukuba.ac.jp";
  
  $body = "\n";
  $body .= "\n　メール送信時にエラーが発生しました。";
  $body .= "\n";
  $body .= "\n　発生日時： " . date('Y/m/d H:m:s');
  $body .= "\n　発生個所： " . $filenameError";
  $body .= "\n　申請番号： " . $entryNo;
  
  $body .= "\n" . $msg;
  $body .= "\n";
  $body .= "\n外部発表審査";
  $body .= "\n　　http://www.prc.tsukuba.ac.jp/papercheck/";
  $body .= "\n以上";
  $body .= "\n";
// echo "Body=(".$body.")<br>";
  
  // メール送信の実行
  if(mb_send_mail($to,$subject,$body,$header)) {
    $_msg = "Sucessed!";
  } else {
    // 再度のメール送信エラーが発生した場合
    
    $_msg = "Faile in mail sending";
    echo $_msg . "\n";
  }
  
  return true;
?>

