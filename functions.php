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


?>
