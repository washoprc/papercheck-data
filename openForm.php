<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(申請)</TITLE>
<LINK href="./hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
<SCRIPT type="text/javascript"><!--
function check() {
  var flag = 0;
  
  if(document.form.requester.value == ""){
    flag = 1;
  } else if(document.form.requesterEmail.value == ""){
    flag = 1;
  } else if(document.form.eventTitle.value == ""){
    flag = 1;
  } else if(document.form.author.value == ""){
    flag = 1;
  } else if(document.form.eventTitle.value == ""){
    flag = 1;
  } else if(document.form.abstract.value == ""){
    flag = 1;
  }
  
  if (flag) {
    window.alert('必須項目に未入力がありました');
    return false;
  } else {
    switch (checkDateFormat(document.form.meetingDate.value)) {
      case 1:
        window.alert('書式が異なっています!\n　　　YYYY/MM/DD');
        document.form.meetingDate.focus();
        return false;
      case 2:
        window.alert('日付が正しくありません!');
        document.form.meetingDate.focus();
        return false;
      default:
        return true;
    }
  }
}

function checkDateFormat(datestr) {
//                    var datestr = document.form.meetingDate.value;
  
  // 正規表現による書式チェック
  if(!datestr.match(/^\d{4}\/\d{2}\/\d{2}$/)){
    return 1;
  }
  
  var trn = 0;
  var vYear = datestr.substr(0, 4) - 0;
  var vMonth = datestr.substr(5, 2) - 1; // Javascriptは、0-11で表現
  var vDay = datestr.substr(8, 2) - 0;
  // 月,日の妥当性チェック
  if(vMonth >= 0 && vMonth <= 11 && vDay >= 1 && vDay <= 31){
    var vDt = new Date(vYear, vMonth, vDay);
    if(isNaN(vDt)){
      rtn = 2;
    }else if(vDt.getFullYear() == vYear && vDt.getMonth() == vMonth && vDt.getDate() == vDay){
      rtn = 0;
    }else{
      rtn = 2;
    }
  }else{
    rtn = 2;
  }
  return rtn;
}
// --></SCRIPT>
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

//  var_dump($_GET);
//  var_dump($_POST);


$_id = $_GET['id'];
$_staffOnly = $_GET['so'];

// if (strlen($_id)>3)
//  $_id = substr($_id,0,3) . str_pad(substr($_id,3),5,0,STR_PAD_LEFT);

// echo "_id=(".$_id.")<br>";                    // xx-1は試行を意味する　　それ以外は新規申請として扱い修正対象とならない


?>
<TABLE width="760" border="0" cellpadding="0" cellspacing="0" class="hpb-main">
  <TBODY>
    <TR>
      <TD>
      
      <TABLE width="613" border="0" align="center" cellpadding="0" cellspacing="0" class="hpb-lb-tb1">
        <TBODY>
        <TR>
          <TD class="hpb-lb-tb1-cell3">
            <BR>
            <BR>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-subh02">
              <TBODY>
              <TR>
                <TD class="hpb-lb-tb1-cell4">外部発表審査</TD>
                <TD class="hpb-lb-tb1-cell4" align="center">
                  <A href="./displayJpg.php"><IMG src="./img/hint.gif" alt="手続き" width="" height="" border="0"></A></TD>
                  <?php
                  $_msg = "";
                  if ($_staffOnly) {
                    $_msg = "<A href='javascript:void(0)' onclick=location.href='./ad/staff_only.php'>";
                    $_msg .= "<FONT color='green'>* 管理 *</FONT></A>";
                  }
                  ?>
                <TD width="100" class="hpb-lb-tb1-cell4"><?php echo $_msg ?></TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                外部に公開する研究内容については、事前に審査を行います。<BR>
                <BR>
                後日、担当審査者からのコメントが返信されます。<BR>
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            
            <?php
            if (!strncasecmp(substr($_id,3,1),"1",1)) {
              $_msg = "<FONT color='green'>　　** 試行中 **</FONT>";
            } else {
              $_msg = "";
            }
            
            $_attribute = "";
            ?>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                  <?php
                  if ($_errorFlag) {
                    echo $_msg;
                  } else {
                    echo "下記のフォームにご記入して、[確認]をクリックしてください。" . $_msg;
                  }
                  ?>
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <FORM method="post" name="form" action="confirmForm.php" onsubmit="return check();">
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1" >
              <TBODY>
              <TR>
                <TD width="20%" align="left" valign="center" class="hpb-cnt-tb-cell1">申請者氏名</TD>
                <TD width="80%" align="left" valign="center" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="requester" size="30" value="" required<?php echo $_attribute ?>></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">　メールアドレス</TD>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell2">
                  <INPUT type="text" name="requesterEmail" size="40" value="" required<?php echo $_attribute ?>></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">題目</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="eventTitle" rows="3" cols="60" required<?php echo $_attribute ?>></TEXTAREA></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">著者</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="author" rows="4" cols="60" required<?php echo $_attribute ?>></TEXTAREA></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">学術誌/会議名 等</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="meetingTitle" rows="3" cols="60" required<?php echo $_attribute ?>></TEXTAREA></TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">会議開催期間</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  from <INPUT type="text" name="meetingDate" size="12" value="" required<?php echo $_attribute ?>>
                  to <INPUT type="text" name="meetingDateTo" size="12" value="" required<?php echo $_attribute ?>>　　書式例：2017/03/28</TD>
              </TR>
              <TR>
                <TD align="left" valign="center" class="hpb-cnt-tb-cell1">論文の要点</TD>
                <TD align="left" valign="top" class="hpb-cnt-tb-cell2">
                  <TEXTAREA name="abstract" rows="10" cols="60" required<?php echo $_attribute ?>></TEXTAREA></TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="bottom" class="hpb-dp-tb4-cell9">
                  学生は今回の申請を指導教員などに連絡してください。該当者をチェックします。
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1" >
              <TBODY>
              <TR>
                <TD height="65" valign="middle" class="hpb-cnt-tb-cell2">
                  <?php
                  $excelfilename = 'EntrySheet.xlsx';
                  $excelfilepath = dirname( __FILE__ ) . '/ad/data/' . $excelfilename;
                  $reader = new XlsxReader;
                  $excel = $reader->load($excelfilepath);
                  
                  $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
                  $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
                  
                  $sRow_reviewer = intval($ws1->getCell('B8')->getValue());
                  
                  $_row = $sRow_reviewer;
                  $_reviewer = $ws1->getCell('B'.$_row)->getValue();
                  $_str = "";
                  while ($_reviewer != "eol" ) {
                    list($_reviewerJname, $_reviewerEname, $_reviewerEmail, $_reviewerActive) = explode("!", $_reviewer);
                    
                    if ($_reviewerEname != "nakashma") {                        // 期間限定の条件 ######  1of2
                      if ($_row !==  $sRow_reviewer)
                        $_str .= ",";
                      
                      $_str .= $_reviewerJname;
                    }
                    
                    if ($_row >= 1000 ) {
                      break;
                    } else {
                      $_row++;
                      $_reviewer = $ws1->getCell('B'.$_row)->getValue();
                    }
                  }
                  
                  $reviewer = explode(",", $_str);
                  
// echo "_str=(".$_str.")<br>";
// var_dump($reviewer);
                  
                  for ($ii=1; $ii <= sizeof($reviewer); $ii++) {
                    if (($ii-1)%6 == 0)
                      $_str = "　";
                    else
                      $_str = "";
                    $_str .= "<INPUT type='checkbox' name='mail_cc[]' value='". $reviewer[$ii-1] ."'>" . $reviewer[$ii-1] . "先生";
                    if ($ii%6 == 0)
                      $_str .= "<BR>";
                    echo $_str . "\n";
                  }
                  $st_reviewer = implode(",", $reviewer);
                  ?>
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="bottom" class="hpb-dp-tb4-cell9">
                  概要などの説明資料の添付操作は[確認]をクリックした後で行います。
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <TABLE width="100%" border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR>
                <TD height="45" valign="middle" class="hpb-cnt-tb-cell2">
                  　<INPUT type="checkbox" name="attachedFile_wo" value="有" checked>　添付する資料ファイルがある　(発表までに準備する場合も含む)
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
                <TR>
                  <TD align="right" valign="top" class="hpb-dp-tb4-cell9">
                    <INPUT type="hidden" name="reviewer" value="<?php echo $st_reviewer ?>">
                    <INPUT type="hidden" name="_id" value="<?php echo $_id ?>">
                    <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                    <INPUT type="submit" name="" value="　確認　"></TD>
                  <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                    <?php
                    if ($_staffOnly) {
                      $_msg = "　中止し管理に戻る　";
                      $_codename = "'./ad/staff_only.php'";
                    } else {
                      $_msg = "ホームに戻る";
                      $_codename = "'http://www.prc.tsukuba.ac.jp/papercheck/'";
                    }
                    ?>
                    <INPUT type="button" name="" value="<?php echo $_msg ?>" onclick="location.href=<?php echo $_codename ?>"></TD>
                </TR>
              </TBODY>
            </TABLE>
            </FORM>
            <BR>
            <BR>
            <BR>
          </TD>
        </TR>
        </TBODY>
      </TABLE>
      
      </TD>
    </TR>
  </TBODY>
</TABLE>
</BODY>
</HTML>