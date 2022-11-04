<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(管理)</TITLE>
<LINK href="../hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
<STYLE type="text/css">
<!--
INPUT[type="submit"] {
   background-image: none;
   border: 1px solid #808080;
   border-radius: 0.3em;
}
--> 
</STYLE>
</HEAD>

<BODY>
<?php
// PhpSpreadsheet ライブラリー
require_once "phpspreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

// 文字コードセット
mb_language("Japanese");
mb_internal_encoding("UTF-8");

/*
var_dump($_POST);
*/

$_staffOnly = 1;

include_once( dirname( __FILE__ ) . '/../functions.php' );

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
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                  幹事は仕組みの維持管理を行います。<BR>
                  　また、状況に応じて入力データの確認・修正を行います。<BR>
                  <BR><FONT size="-1">申請番号;id は年度部(3文字)と連番部(5文字)で構成していますが、この画面の操作では<BR>
                  連番部の連続する上部の０を省いて入力できます。　　例：<?php echo getThisFiscal('y')?>-00010 --> <?php echo getThisFiscal('y')?>-10</FONT></TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            
            <?php
              $excelfilename = 'EntrySheet.xlsx';
              $excelfilepath = dirname( __FILE__ ) . '/data/' . $excelfilename;
              $reader = new XlsxReader;
              $excel = $reader->load($excelfilepath);
              
              $ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
              $ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)
              
              $staff = $ws1->getCell('B4')->getValue();
              list($staffJname, $staffEname, $staffEmail) = explode("!", $staff);
              $testingEmail = $ws1->getCell('B6')->getValue();
            ?>
            
            
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                  ☆ 状況確認<BR>
                  
                  <TABLE border="0" cellpadding="0" cellspacing="2" class="hpb-dp-tb4">
                    <TBODY>
                    <TR><TD width="260"></TD><TD width="190"></TD><TD></TD></TR>
                    <TR align="left">
                      <FORM method="post" action="./tallyReport.php">
                        <TD>　- 利用概況
                        </TD>
                        <TD>&nbsp;</TD>
                        <TD>
                          <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                          <INPUT type="submit" name="" value="Open">
                        </TD>
                      </FORM>
                    </TR>
                    <TR align="left">
                      <FORM method="post" action="./showupByStatus.php">
                        <TD>　- 状況別一覧
                        </TD>
                        <TD>
                          <SELECT name="statuscode">
                            <OPTION value="10" selected>申請;10</OPTION>
                            <OPTION value="21">審査差戻し;21</OPTION>
                            <OPTION value="22">審査者設定済み;22</OPTION>
                            <OPTION value="32">審査1済み;32</OPTION>
                            <OPTION value="33">対応済み;33</OPTION>
                            <OPTION value="34">審査2済み;34</OPTION>
                            <OPTION value="42">確認済み;42</OPTION>
                            <!--<OPTION value="52">完了済み;52</OPTION>-->
                            <OPTION value="90">削除済み;90</OPTION>
                          </SELECT>
                        </TD>
                        <TD>
                          <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                          <INPUT type="submit" name="" value="Open">
                        </TD>
                      </FORM>
                    </TR>
                    <TR align="left">
                      <FORM method="post" action="./summarizeByYear.php">
                        <TD>　- 年度利用一覧　
                          <FONT size="-1"><INPUT type="checkbox" name="chk_st42">判定済み
                        </TD>
                        <TD>
                          <?php
                            $sRow = intval($ws1->getCell('B2')->getValue());
                            $programStartYear = 2016;
                            
                            $fiscalyear = $programStartYear;
                            $_row = $sRow;
                            $_entryNo = $ws2->getCell('B'.$_row)->getValue();
                            $_FiscalYear_Meeting = intval($ws2->getCell('X'.$_row)->getValue());
                            
                           while ($_entryNo != "eol" ) {
                              if ('0' == substr($_entryNo,3,1)) {
                                if ($fiscalyear < $_FiscalYear_Meeting) {
                                  $fiscalyear = $_FiscalYear_Meeting;
                                }
                              }
                              if ($_row >= 1000 ) {
                                break;
                              } else {
                                $_row++;
                                $_entryNo = $ws2->getCell('B'.$_row)->getValue();
                                $_FiscalYear_Meeting = intval($ws2->getCell('X'.$_row)->getValue());
                              }
                            }
                          ?>
                          
                          <SELECT name="FiscalYear">
                          <?php
                            $_fiscalyear = $fiscalyear;
                            while ($_fiscalyear >= $programStartYear) {
                              $_str = "<OPTION value='" . $_fiscalyear . "'";
                              if ($_fiscalyear == $fiscalyear)
                                $_str .= " selected";
                              $_str .= ">" . $_fiscalyear . "</OPTION>\n";
                              echo $_str;
                              $_fiscalyear--;
                            }
                          ?>
                          </SELECT>
                          <FONT size="-1">　会議日基準</FONT>
                        </TD>
                        <TD>
                          <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                          <INPUT type="submit" name="" value="Open">
                        </TD>
                      </FORM>
                    </TR>
                    <TR align="left">
                      <FORM method="post" action="./tallyReviewer.php">
                        <TD colspan="2">　- 審査者毎割当実績</TD>
                        <TD>
                          <INPUT type="hidden" name="TallyBase" value="会議日基準">
                          <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                          <INPUT type="submit" name="" value="Open">
                        </TD>
                      </FORM>
                    </TR>
                    </TBODY>
                  </TABLE>
                  
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                  ☆ 担当者に代わる処理作業<BR>
                  
                  <TABLE border="0" cellpadding="0" cellspacing="2" class="hpb-dp-tb4">
                    <TBODY>
                    <TR><TD width="260"></TD><TD width="190"></TD><TD></TD></TR>
                    <TR height="40" align="left" valign="middle">
                      <FORM method="post" action="_runCode.php">
                        <TD>　- 入力情報の表示</TD>
                        <TD>
                          id= <INPUT type="text" name="entryNo" size="6" maxlength="8" value="<?php echo getThisFiscal('y').'-'; ?>"></TD>
                        <TD>
                          <INPUT type="hidden" name="codename" value="./displayEntry.php">
                          <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                          <INPUT type="submit" name="" value="See"></TD>
                      </FORM>
                    </TR>
                    <TR align="left">
                      <FORM method="post" action="_runCode.php">
                        <TD>　- 「申請」<FONT size="-1">画面</FONT>, ①</TD>
                        <TD>id= <INPUT type="text" name="entryNo" size="6" maxlength="8" value="<?php echo getThisFiscal('y').'-1'; ?>"></TD>
                        <TD>
                          <INPUT type="hidden" name="codename" value="../openForm.php">
                          <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                          <INPUT type="submit" name="" value="Move"></TD>
                      </FORM>
                    </TR>
                    <TR align="left">
                      <FORM method="post" action="_runCode.php">
                        <TD>　- 「割当て」<FONT size="-1">画面</FONT>, ②</TD>
                        <TD>id= <INPUT type="text" name="entryNo" size="6" maxlength="8" value="<?php echo getThisFiscal('y').'-'; ?>"></TD>
                        <TD>
                          <INPUT type="hidden" name="codename" value="assignReviewer.php">
                          <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                          <INPUT type="submit" name="" value="Move"></TD>
                      </FORM>
                    </TR>
                    <TR align="left">
                      <FORM method="post" action="_runCode.php">
                        <TD>　- 「審査」<FONT size="-1">画面</FONT>, ③</TD>
                        <TD>id= <INPUT type="text" name="entryNo" size="6" maxlength="8" value="<?php echo getThisFiscal('y').'-'; ?>"></TD>
                        <TD>
                          <INPUT type="hidden" name="codename" value="../rv/reviewComment.php">
                          <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                          <INPUT type="submit" name="" value="Move"></TD>
                      </FORM>
                    </TR>
                    <TR align="left">
                      <FORM method="post" action="_runCode.php">
                        <TD>　- 「判断/判定」<FONT size="-1">画面</FONT>, ⑥</TD>
                        <TD>id= <INPUT type="text" name="entryNo" size="6" maxlength="8" value="<?php echo getThisFiscal('y').'-'; ?>"></TD>
                        <TD>
                          <INPUT type="hidden" name="codename" value="conductSteps.php">
                          <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                          <INPUT type="submit" name="" value="Move"></TD>
                      </FORM>
                    </TR>
                    </TBODY>
                  </TABLE>
                  
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                  ☆ 入力情報の修正など<BR>
                  
                  <TABLE border="0" cellpadding="0" cellspacing="2" class="hpb-dp-tb4">
                    <TBODY>
                    <TR><TD width="260"></TD><TD width="190"></TD><TD></TD></TR>
                    <TR align="left">
                      <FORM method="post" action="_runCode.php">
                        <TD>　- 入力情報の修正</TD>
                        <TD>
                          id= <INPUT type="text" name="entryNo" size="6" maxlength="8" value="<?php echo getThisFiscal('y').'-'; ?>"></TD>
                         <TD>
                          <INPUT type="hidden" name="codename" value="./maintainEntry.php">
                          <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                          <INPUT type="submit" name="" value="Work"></TD>
                      </FORM>
                    </TR>
                    </TBODY>
                  </TABLE>
                  
                  <TABLE border="0" cellpadding="0" cellspacing="2" class="hpb-dp-tb4">
                    <TBODY>
                    <TR><TD width="260"></TD><TD width="190"></TD><TD></TD></TR>
                    <TR align="left">
                      <FORM method="post" action="_runCode.php">
                        <TD>　- 削除<FONT size="-1"> (フラグ設定のみ)</TD>
                        <TD>
                          id= <INPUT type="text" name="entryNo" size="6" maxlength="8" value="<?php echo getThisFiscal('y').'-'; ?>"></TD>
                        <TD>
                          <INPUT type="hidden" name="codename" value="./deleteEntry.php">
                          <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                          <INPUT type="submit" name="" value="Do"></TD>
                      </FORM>
                    </TR>
                    </TBODY>
                  </TABLE>
                  
                  <TABLE border="0" cellpadding="0" cellspacing="2" class="hpb-dp-tb4">
                    <TBODY>
                    <TR><TD width="260"></TD><TD width="190"></TD><TD></TD></TR>
                    <TR align="left">
                      <FORM method="post" action="_runCode.php">
                        <TD>　- PDF作成(保存用)　
                          <FONT size="-1"><INPUT type="checkbox" name="chk_remand">差戻し用
                        </TD>
                        <TD>
                          cRow= <INPUT type="text" name="cRow" size="6" maxlength="4" value="" placeholder="0001"></TD>
                        <TD>
                          <INPUT type="hidden" name="codename" value="_createPDF.php">
                          <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                          <INPUT type="submit" name="" value="Make"></TD>
                      </FORM>
                    </TR>
                    </TBODY>
                  </TABLE>
                  
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                  ☆ 定期起動タスクの手動実施<BR>
                  
                  <TABLE border="0" cellpadding="0" cellspacing="2" class="hpb-dp-tb4">
                    <TBODY>
                    <TR><TD width="450"></TD><TD></TD></TR>
                    <TR align="left">
                      <FORM method="post" action="_task_tallyReport.php?sc=1">
                        <TD>　- 「利用概況」の更新 <FONT size="-1">[毎日 08:10]</TD>
                        <TD><INPUT type="submit" name="" value="Run"></TD>
                      </FORM>
                    </TR>
                    </TBODY>
                  </TABLE>
                  
                  <TABLE border="0" cellpadding="0" cellspacing="2" class="hpb-dp-tb4">
                    <TBODY>
                    <TR><TD width="450"></TD><TD></TD></TR>
                    <TR align="left">
                      <FORM method="post" action="_task_alert2Staff.php?sc=1">
                        <TD>　- 幹事への処理催促 <FONT size="-1">(条件：Status更新2日経過, 等) [平日 08:15]</TD>
                        <TD><INPUT type="submit" name="" value="Send"></TD>
                      </FORM>
                    </TR>
                    </TBODY>
                  </TABLE>
                  
                  <TABLE border="0" cellpadding="0" cellspacing="2" class="hpb-dp-tb4">
                    <TBODY>
                    <TR><TD width="450"></TD><TD></TD></TR>
                    <TR align="left">
                      <FORM method="post" action="_task_alert2Requester.php?sc=1">
                        <TD>　- 申請者への発表予告メール <FONT size="-1">(条件：審査未実施,会議14日前, 等)</TD>
                        <TD><INPUT type="submit" name="" value="Send"></TD>
                      </FORM>
                    </TR>
                    </TBODY>
                  </TABLE>
                  
                  <TABLE border="0" cellpadding="0" cellspacing="2" class="hpb-dp-tb4">
                    <TBODY>
                    <TR><TD width="450"></TD><TD></TD></TR>
                    <TR align="left">
                      <FORM method="post" action="_task_alert2Reviewer.php?sc=1">
                        <TD>　- 審査者への予告メール <FONT size="-1">(条件：審査未実施,会議10日前, 等)</TD>
                        <TD><INPUT type="submit" name="" value="Send"></TD>
                      </FORM>
                    </TR>
                    </TBODY>
                  </TABLE>
                  
                </TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                  ☆ 利用者の登録<BR>
                  
                  <TABLE border="0" cellpadding="0" cellspacing="2" class="hpb-dp-tb4">
                    <TBODY>
                    <TR><TD width="450"></TD><TD></TD></TR>
                    <TR align="left">
                      <FORM method="post" action="./maintainRequester.php">
                        <TD>　- 申請者の追加・修正・削除・PSW初期化</TD>
                        <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                        <TD><INPUT type="submit" name="" value="Maintain"></TD>
                      </FORM>
                    </TR>
                    </TBODY>
                  </TABLE>
                  
                  <TABLE border="0" cellpadding="0" cellspacing="2" class="hpb-dp-tb4">
                    <TBODY>
                    <TR><TD width="450"></TD><TD></TD></TR>
                    <TR align="left">
                      <FORM method="post" action="./maintainReviewer.php">
                        <TD>　- 審査者となる教員の追加・修正・削除・PSW初期化</TD>
                        <INPUT type="hidden" name="so" value="<?php echo $_staffOnly ?>">
                        <TD><INPUT type="submit" name="" value="Maintain"></TD>
                      </FORM>
                    </TR>
                    </TBODY>
                  </TABLE>
                  
                </TD>
              </TR>
              
              </TBODY>
            </TABLE>
            <BR>
            
            
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <FORM method="post" action="_updatePara.php">
                  <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                    ☆ システムパラメーター<BR>
                    
                    <TABLE border="0" cellpadding="0" cellspacing="2" class="hpb-dp-tb4">
                      <TBODY>
                      <TR><TD width="140"></TD><TD width="310"></TD><TD></TD></TR>
                      <TR align="left">
                        <TD>　幹事名<FONT size="-1"> (漢字)</TD>
                        <TD colspan="2"><INPUT type="text" name="staffJname" size="30" value="<?php echo $staffJname ?>" required>　<FONT size="-1">例. 坂本</TD>
                        <TD></TD>
                      </TR>
                      <TR align="left">
                        <TD>　幹事名<FONT size="-1"> (英字)</TD>
                        <TD colspan="2"><INPUT type="text" name="staffEname" size="30" value="<?php echo $staffEname ?>" required>　<FONT size="-1">例. sakamoto</TD>
                      </TR>
                      <TR align="left">
                        <TD>　幹事メール</TD>
                        <TD colspan="2"><INPUT type="text" name="staffEmail" size="30" value="<?php echo $staffEmail ?>" required>
                          　<INPUT type="submit" name="_action" value="test1"></TD>
                      </TR>
                      <TR height="40" align="left" valign="bottom">
                        <TD>　試行用メール</TD>
                        <TD colspan="2"><INPUT type="text" name="testingEmail" size="30" value="<?php echo $testingEmail ?>" required>
                          　<INPUT type="submit" name="_action" value="test2"></TD>
                      </TR>
                      <TR height="30" align="left" valign="bottom">
                        <TD colspan="2"><FONT size="-1">　　システム管理用ID( bp/bprb2017 )を正規利用者に加えています</TD>
                        <TD><INPUT type="submit" name="_action" value="Update"></TD>
                      </TR>
                      </TBODY>
                    </TABLE>
                    
                  </TD>
                </FORM>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <FORM method="post" action="_updateStaffPasswd.php">
                  <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                    ☆ 幹事パスワードの変更<BR>
                    
                    <TABLE border="0" cellpadding="0" cellspacing="2" class="hpb-dp-tb4">
                      <TBODY>
                      <TR><TD width="450"></TD><TD></TD></TR>
                      <TR align="left">
                        <TD>
                          　- Login-ID <INPUT type="text" size="12" name="staffEname" value="<?php echo $staffEname ?>" disabled>
                          <INPUT type="hidden" name="staffEname" value="<?php echo $staffEname ?>">
                          　Password <INPUT type="text" size="10" name="staffPasswd" value="" placeholder="********" required>
                        </TD>
                        <TD>
                          <INPUT type="submit" name="" value="Change">
                        </TD>
                      </TR>
                      <TR align="right">
                        <TD colspan="2"><FONT size="-1">前回変更日 (<?php echo date("Y/m/d H:i:s", filemtime('.htpass_ad')) ?>)　　　</FONT></TD>
                      </TR>
                      </TBODY>
                    </TABLE>
                    
                  </TD>
                </FORM>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <FORM>
                  <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                    ☆ 参考資料<BR>
                    
                    <TABLE border="0" cellpadding="0" cellspacing="2" class="hpb-dp-tb4">
                      <TBODY>
                      <TR><TD width="450"></TD><TD></TD></TR>
                      <TR align="left">
                        <TD>　- 仕組みのデザイン</TD>
                        <TD><INPUT type="button" name="" value="Open" onclick="location.href='./ref/SystemNote.pdf'"></TD>
                      </TR>
                      <TR align="left">
                        <TD>　- 開発ツールについて</TD>
                        <TD><INPUT type="button" name="" value="Open" onclick="location.href='./ref/Tools.pdf'"></TD>
                      </TR>
                      <TR align="left">
                        <TD>　- 紙様式での申請を依頼する今井先生のメール</TD>
                        <TD><INPUT type="button" name="" value="Open" onclick="location.href='./ref/MessageFromImai.pdf'"></TD>
                      </TR>
                      </TBODY>
                    </TABLE>
                    
                  </TD>
                </FORM>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <FORM>
                  <TD align="left" valign="top" class="hpb-dp-tb4-cell8">
                    ☆ Staff-ID<BR>
                    
                    <TABLE border="0" cellpadding="0" cellspacing="2" class="hpb-dp-tb4">
                      <TBODY>
                      <TR><TD width="160"></TD><TD width="290"></TD><TD></TD></TR>
                      <TR align="left">
                        <TD>　- 現在のLogin-ID</TD>
                        <TD>　<INPUT type="text" size="12" name="loginID" value="<?php echo $_SERVER['PHP_AUTH_USER'] ?>" disabled></TD>
                        <TD><INPUT type="button" name="" value="Log-out" onClick="window.close()" disabled></TD>
                      </TR>
                      </TBODY>
                    </TABLE>
                    
                  </TD>
                </FORM>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <FORM>
                  <TD align="center" valign="top" class="hpb-dp-tb4-cell9">
                    <INPUT type="button" name="" value="ホームに戻る" onclick="location.href='../index.html'">
                </FORM>
              </TR>
              </TBODY>
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


