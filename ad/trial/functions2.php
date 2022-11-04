<?php

// 申請番号の左2文字に使われる年度を確認する
function check_YearOfentryNo($entryNumber){
  return strncasecmp($entryNumber,getThisFiscal('y'),2);          // 0:same  other:not same
}


// 本日の年度を戻す　　　年度は4月1日から翌年3月31日まで
function getThisFiscal($format){
  if (date('n')>=4)                                               // Fiscal year is from April 01 to March 31
    return date($format);
  else
    return str_pad((int)date($format)-1,2,0,STR_PAD_LEFT);
}


// 基となる列番号から指定数右に移動した列番号を求める
function addColumn($column_letter,$add_number){
  
  $len = strlen($column_letter);
  
  for ($i=0; $i<$len; $i++) {
    $cl_chara[$i] = substr($column_letter,$i,1);
    $cl_chara_ord[$i] = intval(ord($cl_chara[$i]));
  }
// echo " (". $cl_chara_ord[$len-2] . " - ".$cl_chara_ord[$len-1].") ";
  
  $cl_chara_ord_sum = $cl_chara_ord[$len-1] + $add_number;
  $orderup = (int)(($cl_chara_ord_sum-65)/26);
  
  $cl_chara_ord[$len-1] = $cl_chara_ord_sum - (26*$orderup);
  $cl_chara_ord[$len-2] = $cl_chara_ord[$len-2] + $orderup;
  
// echo "-->(". $cl_chara_ord[$len-2] . " - ".$cl_chara_ord[$len-1].")<br>";
  return chr($cl_chara_ord[$len-2]).chr($cl_chara_ord[$len-1]);
}


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
}
?>
