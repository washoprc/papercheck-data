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

// 文字コードセット
mb_language("Japanese");
mb_internal_encoding("UTF-8");

//  var_dump($_GET);
//  var_dump($_POST);

$userID = $_GET['uid'];
$_errorNo = $_GET['eno'];


$excelfilename = 'EntrySheet.xlsx';
$excelfilepath = dirname( __FILE__ ) . '/ad/data/' . $excelfilename;

$reader = new XlsxReader;
$excel = $reader->load($excelfilepath);

$ws1 = $excel->setActiveSheetIndexByName('control');          // setActiveSheetIndex(1)
$ws2 = $excel->setActiveSheetIndexByName('Entry');            // setActiveSheetIndex(0)

/*
$obj1 = $ws1->toArray( null, true, true, true );
var_dump($obj1);
echo "<br/>";
$obj2 = $ws2->toArray( null, true, true, true );
var_dump($obj2);
echo "<br/>";
*/

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
                <TD width="100" class="hpb-lb-tb1-cell4"> </TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <TBODY>
              <TR>
                <TD align="left">　ユーザID: [<FONT color="green"><B><?php echo $userID ?></B></FONT>]</TD>
                <TD align="right"><A href="./changePasswd.php?uid=<?php echo $userID ?>">Password更新</A>　　</TD>
              </TR>
              <TR height="8"><TD> </TD></TR>
                <?php
                if (isset($_errorNo) && (int)$_errorNo == 0) {
                  $_msg = "<TR><TD colspan='2' align='right'><FONT color='green'>パスワードは更新されました　　</FONT></TD></TR>";
                  echo $_msg;
                }
                ?>
              <TR>
                <TD colspan="2"><FONT size="-1">
                   　申請の履歴を表示しています。　各行の「No」をクリックすると申請情報を表示します。<BR>
                   　状況欄が「待機」となっている場合、未だ審査が開始されていません。<BR>
                   　　クリックして資料ファイルを添付するなどの作業を完了した後に審査が始まります。
                </FONT></TD>
              </TR>
              </TBODY>
            </TABLE>
            <BR>
            
            <?php
            $_msg = "　　<FONT size='-1'>処理の状況:　申請　->　受付　->　審査1　->　審査2　->　完了</FONT>";
            echo $_msg;
            ?>            
            <TABLE width="100%" border="1" cellpadding="5" cellspacing="0" class="hpb-cnt-tb1">
              <TBODY>
              <TR align="center">
                <TH width="20" class="hpb-cnt-tb-cell1">No</TH>
                <TH width="80" class="hpb-cnt-tb-cell1">申請日</TH>
                <TH class="hpb-cnt-tb-cell1">学会誌/会議名 等</TH>
                <TH width="40" class="hpb-cnt-tb-cell1">状況</TH>
              </TR>
              
              <?php
              $sRow = intval($ws1->getCell('B2')->getValue());
              
              // ユーザIDの申請を抽出する
              $_ii = 0;
              $_row = $sRow;
              $_entryNo = $ws2->getCell('B'.$_row)->getValue();
              $_requesterEmail = $ws2->getCell('D'.$_row)->getValue();
              while (isset($_entryNo) && $_entryNo != "eol") {
                if ($userID == $_requesterEmail) {
                      $meetingTitle = $ws2->getCell('G'.$_row)->getValue();
                      $_statuscode = intval($ws2->getCell('AA'.$_row)->getValue());
                      $_entryDate = $ws2->getCell('AB'.$_row)->getValue();
                      
                      if ($_ii % 2==0)
                        $_class = "hpb-cnt-tb-cell2-a";
                      else
                        $_class = "hpb-cnt-tb-cell2-b";
                      
                      $_msg = "<TR align='left'>\n";
                      $_msg .= "<TD align='right' class='".$_class."'><A href='./displayForm.php?id=".$_entryNo."&uid=".$userID."'>".(int)substr($_entryNo,4)."</A></TD>";
                      $_ii++;
                      $_msg .= "<TD align='center' class='".$_class."'>" . date('Y/m/d',strtotime($_entryDate)) . "</TD>";
                      if (mb_strlen($eventTitle) > 40 ) {
                        $meetingTitle = substr($meetingTitle,0,37) . "...";
                      }
                      $_msg .= "<TD class='".$_class."'>" . $meetingTitle . "</TD>";
                      switch ($_statuscode) {
                        case  8:
                          $_msg2 = "<INPUT type='button' name='action' value='待機' style='background-color:#b0c4de; border:2px solid #8C1F1F; border-radius: 0.3em;' onclick=location.href='./displayForm.php?id=".$_entryNo."&uid=".$userID."'>";
                          break;
                        case 10:
                          $_msg2 = "受付";
                          break;
                        case 22:
                          $_msg2 = "審査１";
                          break;
                        case 32:
                        case 33:
                          $_msg2 = "審査２";
                          break;
                        case 34:
                        case 42:
                          $_msg2 = "完了";
                          break;
                        default:
                          $_msg2 = " -";
                          
                      }
                      $_msg .= "<TD width='40' align='center' class='".$_class."'>" . $_msg2 . "</TD>";
                      $_msg .= "</TR>\n";
                      echo $_msg;
                }
                
                if ($_row >= 1000) {
                  break;
                } else {
                  $_row++;
                  $_entryNo = $ws2->getCell('B'.$_row)->getValue();
                  $_requesterEmail = $ws2->getCell('D'.$_row)->getValue();
                }
                
              }
              
              if ($_ii == 0) {
                $_msg = "<TR><TD align='center' colspan='4' class='hpb-cnt-tb-cell2'>該当なし</TD></TR>";
                echo $_msg;
              }
              ?>
                
              </TBODY>
            </TABLE>
            <BR>
            
            <TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="hpb-dp-tb4">
              <FORM>
              <TBODY>
              <TR>
                <TD align="center" valign="top" class="hpb-dp-tb4-cell9">
                  <INPUT type="button" name="" value="　ホームに戻る　" onclick="location.href='./index.html'"></TD>
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
</HTML>
