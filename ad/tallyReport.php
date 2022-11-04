<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(管理)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>

<BODY>
<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

//  var_dump($_POST);

$_staffOnly = $_POST['so'];

$_TallyBase = '会議日基準';
  
  
?>
<TABLE width="760" border="0" cellpadding="0" cellspacing="0" class="hpb-main">
  <TBODY>
    <TR>
      <TD>
      
      <TABLE width="613" border="0" align="center" cellpadding="0" cellspacing="0" class="hpb-lb-tb1">
        <TBODY>
        <TR>
          <TD class="hpb-lb-tb1-cell3"><BR>
            <BR>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-subh02">
              <TBODY>
              <TR>
                <TD class="hpb-lb-tb1-cell4">外部発表審査</TD>
                <TD class="hpb-lb-tb1-cell4" align="center">
                  <A href="../displayJpg.php"><IMG src="../img/hint.gif" alt="手続き" width="" height="" border="0"></A></TD>
                  <?php
                  $_msg = "";
                  if ($_staffOnly) {
                    $_msg = "<A href='javascript:void(0)' onclick=location.href='./staff_only.php'>";
                    $_msg .= "<FONT color='green'>* 管理 *</FONT></A>";
                  }
                  ?>
                <TD width="100" class="hpb-lb-tb1-cell4"><?php echo $_msg ?></TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            
            <BR>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD>　　集計件数結果:　　</TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <TABLE border="0" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR align="center">
                <TD width="110" rowspan="2" class="hpb-cnt-tb-cell1">年度<BR><FONT size="-2">(<?php echo $_TallyBase?>)</FONT></TD>
                <TD width="55" rowspan="2" class="hpb-cnt-tb-cell1">申請</TD>
                <TD width="55" rowspan="2" class="hpb-cnt-tb-cell1">審査中</TD>
                <TD colspan="4" class="hpb-cnt-tb-cell1">判定済み</TD>
              </TR>
              <TR align="center" height="20">
                <TD width="55" class="hpb-cnt-tb-cell1"><FONT size="-1">承認</FONT></TD>
                <TD width="55" class="hpb-cnt-tb-cell1"><FONT size="-1">不承認</FONT></TD>
                <TD width="55" class="hpb-cnt-tb-cell1"><FONT size="-1">保留</FONT></TD>
                <TD width="55" class="hpb-cnt-tb-cell1"><FONT size="-1">合計</FONT></TD>
              </TR>
              
              
              <?php
              $textfilename = 'currentTally.txt';
              $textfilepath = dirname( __FILE__ ) . '/yearly/' . $textfilename;
              
              if (is_file($textfilepath)) {
                $array = file( $textfilepath, FILE_IGNORE_NEW_LINES);
// var_dump($array);
                
                
                foreach ($array as $line) {
                  if (strpos($line, '//') === false) {
                    if ($line !== "") {
                      $perform = explode("!", $line);
                      // A line consists of Year, Entry, Working, Approval, Disapproval, Pending, Summation
                      $tally = "<TR align='right'>\n";
                      for ($j=0; $j<=6; $j++) {
                        if ($j===0)
                          $tally .= "<TD align='center' class='hpb-cnt-tb-cell1'>".$perform[$j]."</TD>\n";
                        else
                          $tally .= "<TD class='hpb-cnt-tb-cell2'>".$perform[$j]."</TD>\n";
                      }
                      $tally .= "</TR>\n";
                      echo $tally;
                    }
                  }
                }
                
                
              } else {
                $tally = "<TR align='center'><TD colspan='7' class='hpb-cnt-tb-cell2'>集計ファイルが準備できていません</TD></TR>\n";
                echo $tally;
              }
              ?>
              
              
              </TBODY>
            </TABLE>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left">　　　<FONT size="-1">as of <?php echo date("Y/m/d H:i:s", filemtime($textfilepath)) ?></TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <FORM>
              <TBODY>
              <TR>
                <TD align="center" valign="top" class="hpb-dp-tb4-cell9">
                  <INPUT type="button" name="" value="　管理に戻る　" onclick="location.href='./staff_only.php'"></TD>
              </TR>
              </TBODY>
              </FORM>
            </TABLE>
            
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