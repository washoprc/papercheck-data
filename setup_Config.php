<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>計測システム</TITLE>
<LINK href="./hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>
<BODY>

<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

  // 設定ファイル
  $filename = 'Config.txt';
  define(CONFIG, dirname( __FILE__ ) . '/data/' . $filename);
  
  // エラーファイル
  $error_filename = 'Error.html';
  define(ERROR, dirname( __FILE__ ) . '/data/' . $error_filename);
  
  // 更新確認ファイル
  $filename = 'action.txt';
  define(ACTION, dirname( __FILE__ ) . '/tmp/' . $filename);
  
  // 構成設定 　７要素
  $no_item_tt = 7;
  $item_name_tt = array("T", "収集器#", "端末器#", "計測間隔", "制御", "設置日", "設置状況");
  
  // 収集器設定データ　１０要素
  $no_item_dd = 10;
  $item_name_dd = array("D", "収集器#", "Macアドレス", "IPアドレス", "通信", "組立日", "基板", "電源", "蓄積器#", "備考");
  
  // 端末器設定データ　１１要素
  $no_item_rr = 11;
  $item_name_rr = array("R", "端末器#", "Macアドレス", "IPアドレス", "通信", "組立日", "基板", "計測対象", "センサー", "電源", "備考");
  
  // 蓄積器設定データ　５要素
  $no_item_ss = 5;
  $item_name_ss = array("S", "蓄積器#", "IPアドレス", "電源", "備考");
  
  
  if (!file_exists(CONFIG)) {
    echo "<br><FONT color='red'>　ファイルが見つかりません</FONT><br>　　".CONFIG;
  } else {
    
    // ファイルの内容を行ごとに配列に取り込む
    $lns = file(CONFIG);
    
    // 操作時に行を識別するために行番号を行の先頭に設定する
    foreach ($lns as $ln_num => $ln) {
      $lines[] = sprintf("%05d",$ln_num+1) . ', ' . $ln;
    }
/* check
foreach ($lines as $ln_num => $ln) {
  echo "Line #<b>{$ln_num}</b> : " . htmlspecialchars($ln) . "<br />\n";
}
*/
  
  
  // 設定要素を配列に取り込む
  foreach ($lines as $line) {
    $vline = htmlspecialchars($line);
    
    switch (substr($vline,7,1)) {
      case $item_name_tt[0]:
        $TT[] = explode(',', $vline, $no_item_tt+2);
        break;
      case $item_name_dd[0]:
        $DD[] = explode(',', $vline, $no_item_dd+2);
        break;
      case $item_name_rr[0]:
        $RR[] = explode(',', $vline, $no_item_rr+2);
        break;
      case $item_name_ss[0]:
        $SS[] = explode(',', $vline, $no_item_ss+2);
        break;
      default:
        echo "not defined elements<BR>";
    }
  }
  
//  if (file_exists(ERROR)) {
//    $str = "<SCRIPT type='text/JavaScript'>window.open('./data/".$error_filename."', target='subError','width=800,height=600');</SCRIPT>";
//    echo $str;
//  }
  
/* check
var_dump($TT);
var_dump($DD);
var_dump($RR);
var_dump($SS);
*/
  
  if (!file_exists(ACTION))
    $attribute = " disabled";
  else
    $attribute = "";  
}

?>

<TABLE width="1020" border="0" cellpadding="0" cellspacing="0" class="hpb-main">
  <TBODY>
    <TR>
      <TD>
      
      <TABLE border="0" align="leftr" cellpadding="0" cellspacing="0" class="hpb-lb-tb4">
        <TBODY>
        <TR>
          <TD class="hpb-lb-tb1-cell3">
            <BR>
            <BR>
            
            ☆ 構成設定(T)
            <TABLE width="540" border="1" cellpadding="0" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR align="center">
                <TD width="65" class="hpb-cnt-tb-cell1">操作</TD>
                  <TD width="60" class="hpb-cnt-tb-cell1"><?php echo $item_name_tt[1];?></TD><TD width="60" class="hpb-cnt-tb-cell1"><?php echo $item_name_tt[2];?></TD>
                  <TD width="80" class="hpb-cnt-tb-cell1"><?php echo $item_name_tt[3];?></TD><TD width="60" class="hpb-cnt-tb-cell1"><?php echo $item_name_tt[4];?></TD>
                  <TD width="90" class="hpb-cnt-tb-cell1"><?php echo $item_name_tt[5];?></TD><TD class="hpb-cnt-tb-cell1"><?php echo $item_name_tt[6];?></TD>
              </TR>
              <FORM>
              <?php
              foreach ($TT as $array_TT) {
                $str = "<TR height='30' align='center' valign='middle'>\n";
                $str .= "<TD class='hpb-cnt-tb-cell1'> <INPUT type='button' name='' value='更' onClick=window.open('./setup_Config_TT.php?ac=update&ln=".$array_TT[0]."','_subTT','resizable=yes,width=430,height=380');return false; style='font-size:90%'> ";
                $str .= "<INPUT type='button' name='' value='削' onClick=window.open('./setup_Config_TT.php?ac=delete&ln=".$array_TT[0]."','_subTT','resizable=yes,width=430,height=380');return false; style='font-size:90%'> </TD>\n";
                for ($i=2; $i<=$no_item_tt; $i++) {
                  $str .= "<TD class='hpb-cnt-tb-cell2'>";
                  if (empty($array_TT[$i]))
                    $str .= "";
                  else
                    $str .= $array_TT[$i];
                  $str .= "</TD>";
                }
                $str .= "</TR>\n";
                echo $str;
              }
              $str = "<TR height='30' align='center' valign='middle'>\n";
              $str .= "<TD class='hpb-cnt-tb-cell1'><INPUT type='button' name='' value='追' onClick=window.open('./setup_Config_TT.php?ac=add&ln=".$array_TT[0]."','_subTT','resizable=yes,width=430,height=380');return false; style='font-size:90%'> </TD>\n";
              $str .= "<TD colspan='".$no_item_tt."' class='hpb-cnt-tb-cell2'> </TD>";
              $str .= "</TR>\n";
              echo $str;
              ?>
              </FORM>
              </TBODY>
            </TABLE>
            <BR>
            <BR>
            
            ☆ 収集器設定(D)
            <TABLE width="900" border="1" cellpadding="0" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR align="center">
                <TD width="65" class="hpb-cnt-tb-cell1">操作</TD>
                  <TD width="60" class="hpb-cnt-tb-cell1"><?php echo $item_name_dd[1];?></TD><TD width="100" class="hpb-cnt-tb-cell1"><?php echo $item_name_dd[2];?></TD>
                  <TD width="120" class="hpb-cnt-tb-cell1"><?php echo $item_name_dd[3];?></TD><TD class="hpb-cnt-tb-cell1"><?php echo $item_name_dd[4];?></TD>
                  <TD width="90" class="hpb-cnt-tb-cell1"><?php echo $item_name_dd[5];?></TD><TD class="hpb-cnt-tb-cell1"><?php echo $item_name_dd[6];?></TD>
                  <TD class="hpb-cnt-tb-cell1"><?php echo $item_name_dd[7];?></TD><TD width="60" class="hpb-cnt-tb-cell1"><?php echo $item_name_dd[8];?></TD>
                  <TD class="hpb-cnt-tb-cell1"><?php echo $item_name_dd[9];?></TD>
              </TR>
              <FORM>
              <?php
              foreach ($DD as $array_DD) {
                $str = "<TR height='30' align='center' valign='middle'>\n";
                $str .= "<TD class='hpb-cnt-tb-cell1'> <INPUT type='button' name='' value='更' onClick=window.open('./setup_Config_DD.php?ac=update&ln=".$array_DD[0]."','_subDD','resizable=yes,width=430,height=480');return false; style='font-size:90%'> ";
                $str .= "<INPUT type='button' name='' value='削' onClick=window.open('./setup_Config_DD.php?ac=delete&ln=".$array_DD[0]."','_subDD','resizable=yes,width=430,height=480');return false; style='font-size:90%'> </TD>\n";
                for ($i=2; $i<=$no_item_dd; $i++) {
                  $str .= "<TD class='hpb-cnt-tb-cell2'>";
                  if (empty($array_DD[$i]))
                    $str .= "";
                  else
                    $str .= $array_DD[$i];
                  $str .= "</TD>";
                }
                $str .= "</TR>\n";
                echo $str;
              }
              $str = "<TR height='30' align='center' valign='middle'>\n";
              $str .= "<TD class='hpb-cnt-tb-cell1'><INPUT type='button' name='' value='追' onClick=window.open('./setup_Config_DD.php?ac=add&ln=".$array_DD[0]."','_subDD','resizable=yes,width=430,height=480');return false; style='font-size:90%'> </TD>\n";
              $str .= "<TD colspan='".$no_item_dd."' class='hpb-cnt-tb-cell2'> </TD>";
              $str .= "</TR>\n";
              echo $str;
              ?>
              </FORM>
              </TBODY>
            </TABLE>
            <BR>
            <BR>
            
            ☆ 端末器設定(R)
            <TABLE width="950" border="1" cellpadding="0" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR align="center">
                <TD width="65" class="hpb-cnt-tb-cell1">操作</TD>
                  <TD width="60" class="hpb-cnt-tb-cell1"><?php echo $item_name_rr[1];?></TD><TD width="100" class="hpb-cnt-tb-cell1"><?php echo $item_name_rr[2];?></TD>
                  <TD class="hpb-cnt-tb-cell1"><?php echo $item_name_rr[3];?></TD><TD class="hpb-cnt-tb-cell1"><?php echo $item_name_rr[4];?></TD>
                  <TD width="90" class="hpb-cnt-tb-cell1"><?php echo $item_name_rr[5];?></TD><TD class="hpb-cnt-tb-cell1"><?php echo $item_name_rr[6];?></TD>
                  <TD class="hpb-cnt-tb-cell1"><?php echo $item_name_rr[7];?></TD><TD class="hpb-cnt-tb-cell1"><?php echo $item_name_rr[8];?></TD>
                  <TD class="hpb-cnt-tb-cell1"><?php echo $item_name_rr[9];?></TD><TD class="hpb-cnt-tb-cell1"><?php echo $item_name_rr[10];?></TD>
              </TR>
              <FORM>
              <?php
              foreach ($RR as $array_RR) {
                $str = "<TR height='30' align='center' valign='middle'>\n";
                $str .= "<TD class='hpb-cnt-tb-cell1'> <INPUT type='button' name='' value='更' onClick=window.open('./setup_Config_RR.php?ac=update&ln=".$array_RR[0]."','_subRR','resizable=yes,width=430,height=520');return false; style='font-size:90%'> ";
                $str .= "<INPUT type='button' name='' value='削' onClick=window.open('./setup_Config_RR.php?ac=delete&ln=".$array_RR[0]."','_subRR','resizable=yes,width=430,height=520');return false; style='font-size:90%'> </TD>\n";
                for ($i=2; $i<=$no_item_rr; $i++) {
                  $str .= "<TD class='hpb-cnt-tb-cell2'>";
                  if (empty($array_RR[$i]))
                    $str .= "";
                  else
                    $str .= $array_RR[$i];
                  $str .= "</TD>";
                }
                $str .= "</TR>\n";
                echo $str;
              }
              $str = "<TR height='30' align='center' valign='middle'>\n";
              $str .= "<TD class='hpb-cnt-tb-cell1'><INPUT type='button' name='' value='追' onClick=window.open('./setup_Config_RR.php?ac=add&ln=".$array_RR[0]."','_subRR','resizable=yes,width=430,height=520');return false; style='font-size:90%'> </TD>\n";
              $str .= "<TD colspan='".$no_item_rr."' class='hpb-cnt-tb-cell2'> </TD>";
              $str .= "</TR>\n";
              echo $str;
              ?>
              </FORM>
              </TBODY>
            </TABLE>
            <BR>
            <BR>
            
            ☆ 蓄積器設定(S)
            <TABLE width="430" border="1" cellpadding="0" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR align="center">
                <TD width="65" class="hpb-cnt-tb-cell1">操作</TD>
                  <TD width="60" class="hpb-cnt-tb-cell1"><?php echo $item_name_ss[1];?></TD><TD width="120" class="hpb-cnt-tb-cell1"><?php echo $item_name_ss[2];?></TD>
                  <TD class="hpb-cnt-tb-cell1"><?php echo $item_name_ss[3];?></TD><TD class="hpb-cnt-tb-cell1"><?php echo $item_name_ss[4];?></TD>
              </TR>
              <FORM>
              <?php
              foreach ($SS as $array_SS) {
                $str = "<TR height='30' align='center' valign='middle'>\n";
                $str .= "<TD class='hpb-cnt-tb-cell1'> <INPUT type='button' name='' value='更' onClick=window.open('./setup_Config_SS.php?ac=update&ln=".$array_SS[0]."','_subSS','resizable=yes,width=430,height=310');return false; style='font-size:90%'> ";
                $str .= "<INPUT type='button' name='' value='削' onClick=window.open('./setup_Config_SS.php?ac=delete&ln=".$array_SS[0]."','_subSS','resizable=yes,width=430,height=310');return false; style='font-size:90%'> </TD>\n";
                for ($i=2; $i<=$no_item_ss; $i++) {
                  $str .= "<TD class='hpb-cnt-tb-cell2'>";
                  if (empty($array_SS[$i]))
                    $str .= "";
                  else
                    $str .= $array_SS[$i];
                  $str .= "</TD>";
                }
                $str .= "</TR>\n";
                echo $str;
              }
              $str = "<TR height='30' align='center' valign='middle'>\n";
              $str .= "<TD class='hpb-cnt-tb-cell1'><INPUT type='button' name='' value='追' onClick=window.open('./setup_Config_SS.php?ac=add&ln=".$array_SS[0]."','_subSS','resizable=yes,width=430,height=310');return false; style='font-size:90%'> </TD>\n";
              $str .= "<TD colspan='".$no_item_ss."' class='hpb-cnt-tb-cell2'> </TD>";
              $str .= "</TR>\n";
              echo $str;
              ?>
              </FORM>
              </TBODY>
            </TABLE>
            <BR>
            <BR>
            
            
            <TABLE width="60%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <FORM>
              <TBODY>
              <TR align="left" valign="top">
                <TD width="20" class="hpb-dp-tb4-cell9"> 
                </TD>
                <TD class="hpb-dp-tb4-cell9">
                  <INPUT type="button" name="" value="　ホームに戻る　" onclick="location.href='./index.html'">
                </TD>
                <TD class="hpb-dp-tb4-cell9">
                  <INPUT type="button" name="" value="　入力確認　" onClick=window.open('./setup_Config_valid.php','_subCheck','resizable=yes,width=570,height=540');return false;<?php echo $attribute ?>>
                </TD>
                <TD class="hpb-dp-tb4-cell9"> 
                </TD>
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
