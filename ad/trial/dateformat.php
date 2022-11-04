<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>DATE FORMAT</TITLE>
</HEAD>

<BODY>


<FORM method="get" name="sp" action="confirmForm.php" onsubmit="return ckDate();">

<INPUT type="text" name ="date2" value="">

<INPUT type="submit" value="送信">
</FORM>


<?php
$sample = "2013-11-30";

if (checkDateFormat($sample)) {
  echo "--> These are same format";
} else {
  echo "--> Two formats are not same.";
}


function checkDateFormat($datetime){
  echo $datetime. " " . strtotime($datetime) . " " . date("Y-m-d", strtotime($datetime)) . "<br>";
    return $datetime === date("Y-m-d", strtotime($datetime));
}

?>

<script>
function checkDateFormat2() {
  st = document.sp.date2.value;
  alert("日付書式のチェック" + st);
  return false;
}

/****************************************************************
* 機　能： 入力された値が日付でYYYY/MM/DD形式になっているか調べる
* 引　数： datestr　入力された値
* 戻り値： 正：true　不正：false
****************************************************************/
function ckDate() {

    datestr = document.sp.date2.value;
    
    // 正規表現による書式チェック
    if(!datestr.match(/^\d{4}\/\d{2}\/\d{2}$/)){
        alert("Error on regular expression");
        return false;
    }
    var vYear = datestr.substr(0, 4) - 0;
    var vMonth = datestr.substr(5, 2) - 1; // Javascriptは、0-11で表現
    var vDay = datestr.substr(8, 2) - 0;
    // 月,日の妥当性チェック
    if(vMonth >= 0 && vMonth <= 11 && vDay >= 1 && vDay <= 31){
        var vDt = new Date(vYear, vMonth, vDay);
        if(isNaN(vDt)){
            rtn = false;
        }else if(vDt.getFullYear() == vYear && vDt.getMonth() == vMonth && vDt.getDate() == vDay){
            rtn = true;
        }else{
            rtn = false;
        }
    }else{
        rtn = false;
    }
    
    if (!rtn) alert("Wrong format!");

    return rtn;
}

</script>

</BODY>
</HTML>
