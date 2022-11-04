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
// PhpSpreadsheet ライブラリー
require_once "phpspreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

/*
var_dump($_GET);
var_dump($_POST);
*/

$taskcode = $_GET['tk'];
// $sn = $_GET['sn'];
$requester = $_GET['req'];
$requesterEmail = $_GET['reqe'];
// $Passwd = $_GET['pwd'];
$createdDate = $_GET['cdt'];
$updatedDate = $_GET['udt'];
$_errorNo = $_GET['eno'];
$_staffOnly_p = $_POST['so'];
$_staffOnly_g = $_GET['so'];

if (isset($_staffOnly_p))
  $_staffOnly = $_staffOnly_p;
else
  if (isset($_staffOnly_g))
    $_staffOnly = $_staffOnly_g;
  else
    $_staffOnly = 0;

if (!isset($taskcode))
  $taskcode = 0;        // '追加'

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
            
            <?php
            $excelfilename = 'Requesters.xlsx';
            $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
            $reader = new XlsxReader;
            $excel = $reader->load($excelfilepath);
            
            $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
            $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
            
            $sRow = intval($ws1->getCell('B2')->getValue());
            ?>
            
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                  
                  <TABLE border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4-cell9">
                    <TBODY>
                    <TR>
                      <TD colspan="2"><FONT size="+0">操作手順</TD>
                    </TR>
                    <TR align="left">
                      <TD width="30" align="right">１．</TD>
                      <TD>処理内容を選択する</TD>
                    </TR>
                    <TR>
                      <TD align="right">２．</TD>
                      <TD>追加の場合　登録する方の氏名とEアドレスの入力をする</TD>
                    </TR
                    <TR>
                      <TD align="right"></TD>
                      <TD>修正の場合　リストから対象者を指定して選択ボタンを押す</TD>
                    </TR>
                    <TR>
                      <TD align="right"></TD>
                      <TD>　　　　　　表示される２項目を修正する</TD>
                    </TR>
                    <TR>
                      <TD align="right"></TD>
                      <TD>削除の場合　リストから対象者を指定して選択ボタンを押す</TD>
                    </TR>
                    <TR>
                      <TD align="right"></TD>
                      <TD>PSW初期化の場合　リストから対象者を指定して選択ボタンを押す</TD>
                    </TR>
                    <TR>
                      <TD align="right">４．</TD>
                      <TD>処理の実行ボタンを押す</TD>
                    </TR>
                    <TR>
                      <TD align="right">５．</TD>
                      <TD>下部に表示される一覧から処理内容を確認する</TD>
                    </TR>
                    </TBODY>
                  </TABLR>
                  
                  <FORM method="post" action="_getRequester.php">
                  <TABLE border="0" cellpadding="0" cellspacing="6" class="hpb-dp-tb4">
                    <TBODY>
                    <TR align="left">
                      <TD>　処理内容：　</TD>
                      <TD>
                        <INPUT type="radio" name="task" value="0追加" required<?php if ($taskcode==0) echo ' checked' ?>>追加,　
                        <INPUT type="radio" name="task" value="1修正" required<?php if ($taskcode==1) echo ' checked' ?>>修正,　
                        <INPUT type="radio" name="task" value="2削除" required<?php if ($taskcode==2) echo ' checked' ?>>削除　
                        <INPUT type="radio" name="task" value="3初期化" required<?php if ($taskcode==3) echo ' checked' ?>>PSW初期化　
                      </TD>
                    </TR>
                    <TR>
                      <TD>　対象者：　</TD>
                      <TD>　　　
                        <SELECT name="requesterEmail">
                        
                        <?php
                        if ((int)$taskcode > 0) {
                          // ここを埋める
                        }
                        
                        $_row = $sRow;
                        $_requesterEmail = $ws2->getCell('C'.$_row)->getValue();
                        
                        while ($_requesterEmail != "eol" ) {
                          
                          $_requester = $ws2->getCell('B'.$_row)->getValue();
                          $_msg = "<OPTION value='" . $_requesterEmail . "'";
                          if (!strcasecmp($_requester, $requester)) {
                            $_msg .= " selected";
                            $cRow = $_row;
                          }
                          $_msg .= ">" . $_requester . "</OPTION>\n";
                          echo $_msg;
                          
                          if ($_row >= 1000 ) {
                            break;
                          } else {
                            $_row++;
                            $_requesterEmail = $ws2->getCell('C'.$_row)->getValue();
                          }
                        }
                        ?>
                        
                        </SELECT>
                        　<INPUT type="submit" name="" value="選択">
                        <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                      </TD>
                    </TR>
                    </TBODY>
                  </TABLE>
                  </FORM>
                  
                  <?php
                  if (!isset($taskcode) || $taskcode == "0") {
                    $sn = "";
                    $requester = "";
                    $requesterEmail = "";
                    $Passwd = "";
                    $createdDate = date('Y/m/d H:i:s');
                    $updatedDate = date('Y/m/d H:i:s');
                  } else {
                    $sn = $sn;
                    $requester = $requester;
                    $requesterEmail = $requesterEmail;
                    $Passwd = "*";
                    $createdDate = $createdDate;
                    $updatedDate = $updatedDate;
                  }
                  
                  ?>
                  
                  <FORM method="post" action="_setRequester.php">
                  <TABLE border="0 cellpadding="0" cellspacing="6" class="hpb-dp-tb4">
                    <TBODY>
<!--
                    <TR align="left">
                      <TD width="140" class="hpb-cnt-tb-cell1">　連番</TD>
                      <TD><INPUT type="text" name="sn" size="6" value="<?php echo $sn; ?>" required></TD>
                    </TR>
-->
                    <TR align="left">
                      <TD width="140" class="hpb-cnt-tb-cell1">　氏名</TD>
                      <TD><INPUT type="text" name="requester" size="30" value="<?php echo $requester; ?>" required></TD>
                    </TR>
                    <TR align="left">
                      <TD width="140" class="hpb-cnt-tb-cell1">　メールアドレス (ID)</TD>
                      <TD><INPUT type="text" name="requesterEmail" size="30" value="<?php echo $requesterEmail; ?>" required></TD>
                    </TR>
                    <TR><TD colspan="2" height="3"> </TD></TR>
<!--
                    <TR>
                      <TD class="hpb-cnt-tb-cell1">　パスワード</TD>
                      <TD><INPUT type="text" name="Passwd" size="30" value="<?php echo $Passwd; ?>" disabled></TD>
                    </TR>
-->
                    <TR>
                      <TD class="hpb-cnt-tb-cell1">　作成日時</TD>
                      <TD><INPUT type="text" name="createdDate" size="20" value="<?php echo $createdDate; ?>" disabled></TD>
                    </TR>
                    <TR>
                      <TD class="hpb-cnt-tb-cell1">　最終更新日時</TD>
                      <TD><INPUT type="text" name="updatedDate" size="20" value="<?php echo $updatedDate; ?>" disabled></TD>
                    </TR>
                    </TBODY>
                  </TABLE>
                  <INPUT type="hidden" name="cRow" value="<?php echo $cRow; ?>">
                  <INPUT type="hidden" name="taskcode" value="<?php echo $taskcode; ?>">
                  <INPUT type="hidden" name="requester_old" value="<?php echo $requester; ?>">
                  <INPUT type="hidden" name="requesterEmail_old" value="<?php echo $requesterEmail; ?>">
                  <INPUT type="hidden" name="so" value="<?php echo $_staffOnly; ?>">
                  <BR>　　　　　　<INPUT type="submit" value="処理を実行">
                  　　<INPUT type="button" name="" value="中止し管理に戻る" onclick="location.href='./staff_only.php'">
                  </FORM>
                  
                  <?php
                  if (isset($_errorNo) && is_numeric($_errorNo)) {
                    $_msg = "　　　";
                    switch ((int)$_errorNo) {
                      case 0:
                        $_msg .= "<FONT color='green'>正常に処理を終了</FONT>\n";
                        break;
                      case 1;
                        $_msg .= "<FONT color='red'>審査者のPSW変更はできません</FONT>\n";
                        break;
                      default:
                        $_msg .= "<FONT color='red'>予期しないエラーコード (".$_errorNo.")</FONT>\n";
                    }
                    echo $_msg;
                  }
                  ?>
                  
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            
            
            <BR>
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell9">
                  現在、登録されている方々です。<BR>
                  通常、初回申請時のメールアドレスをユーザIDとして自動登録します。</TD>
              </TR>
              </TBODY>
            </TABLE>
            
            <TABLE width="100%" border="1" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR height="30" align="center">
                <TH width="30" class="hpb-cnt-tb-cell1">s/n</TH>
                <TH width="70" class="hpb-cnt-tb-cell1">氏　名</TH>
                <TH class="hpb-cnt-tb-cell1">メールアドレス(ID)</TH>
<!--
                <TH width="30" class="hpb-cnt-tb-cell1">PSW</TH>
                <TH width="30" class="hpb-cnt-tb-cell1">作成</TH>
                <TH width="30" class="hpb-cnt-tb-cell1">更新</TH>
-->
              </TR>
              
              <?php
              $_ii = 0;
              $_row = $sRow;
              $_requesterEmail = $ws2->getCell('C'.$_row)->getValue();
              
              while ($_requesterEmail != "eol" ) {
                
                $_sn = $_ii+1;
                $_requester = $ws2->getCell('B'.$_row)->getValue();
                $_Passwd = $ws2->getCell('E'.$_row)->getValue();
                $_createdDate = $ws2->getCell('G'.$_row)->getValue();
                $_updatedDate = $ws2->getCell('H'.$_row)->getValue();
                
                if ($_ii % 2==0)
                  $_class = "hpb-cnt-tb-cell2-a";
                else
                  $_class = "hpb-cnt-tb-cell2-b";
                $_ii++;
                
                $_msg = "<TR>\n";
                $_msg .= "<TD align='right' class='".$_class."'>".$_sn."</TD>";
                $_msg .= "<TD class='".$_class."'>".$_requester."</TD>";
                $_msg .= "<TD class='".$_class."'>".$_requesterEmail."</TD>";
/*
                $_msg .= "<TD align='center' class='".$_class."'>"."*"."</TD>";
                $_msg .= "<TD align='center' class='".$_class."'>"."*"."</TD>";
                $_msg .= "<TD align='center' class='".$_class."'>"."*"."</TD>";
*/
                $_msg .= "</TR>\n";
                echo $_msg;
                
                if ($_row >= 1000 ) {
                  break;
                } else {
                  $_row++;
                  $_requesterEmail = $ws2->getCell('C'.$_row)->getValue();
                }
              }
              ?>
              </TBODY>
            </TABLE>
            <BR>
            
            
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