<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE>PRC_外部発表審査(管理)</TITLE>
<LINK href="./hpbBP01.css" rel="stylesheet" type="text/css" id="hpbBP01">
</HEAD>

<BODY>
<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");

/*
var_dump($_GET);
*/

$_fromNo = $_GET['fn'];
$_staffOnly = $_GET['so'];
$entryNo = $_GET['en'];
$backDisplay = (int)$_GET['bD'];
$statusCodeShow = $_GET['sCS'];
$fiscalYear = $_GET['fy'];
$OrderDisplay = $_GET['od'];

if (!isset($backDisplay))
  $backDisplay = 0;
  
  
  switch ((int)$_fromNo) {
    
    case 1:
      // 申請者へ　*** openForm -> saveForm ***
      $_msg = "<BR>　入力された情報は登録されました<BR>";
      $_msg .= "<BR>　　申請番号: " . $entryNo . " です<BR>";
      $_msg .= "<BR>";
      $_msg .= "<FORM>";
      if ($_staffOnly) {
        $_str = "　管理に戻る　";
        $_codename = "location.href='./ad/staff_only.php'";
      } else {
        $_str = "　申請に戻る　";
        $_codename = "location.href='http://www.prc.tsukuba.ac.jp/papercheck/openForm.php'";
      }
      $_msg .= "<INPUT type='button' name='' value='" . $_str . "' onclick=" . $_codename . ">";
      $_msg .= "</FORM>";
      $_msg .= "<BR>";
      break;
      
    case 2:
      // 幹事へ　*** assignReviewer -> saveReviewer ***
      $_msg = "<BR>　審査者設定の処理が実施されました<BR>";
       $_msg .= "<BR>　　申請番号: " . $entryNo . " です<BR>";
      $_msg .= "<BR>";
      $_msg .= "<FORM>";
      if ($_staffOnly) {
        if ($backDisplay==2) {
          $_str = "閉じる";
          $_codename = "window.close()";
        } else {
          $_str = "　管理に戻る　";
          $_codename = "location.href='./ad/staff_only.php'";
        }
      } else {
        $_str = "　前画面に戻る　";
        $_codename = "location.href='./ad/summarizeByYear.php?so=".$_staffOnly."&fy=".$fiscalYear."&od=".$OrderDisplay."'";
      }
      $_msg .= "<INPUT type='button' name='' value='" . $_str . "' onclick=" . $_codename . ">";
      $_msg .= "</FORM>";
      $_msg .= "<BR>";
      break;
      
    case 3:
      // 審査者へ　*** reviewComment -> saveComment ***
      $_msg = "<BR>　審査１の処理が実施されました<BR>";
      $_msg .= "<BR>　　申請番号: " . $entryNo . " です<BR>";
      $_msg .= "<BR>";
      $_msg .= "<FORM>";
      if ($_staffOnly) {
        $_str = "　管理に戻る　";
        $_codename = "location.href='./ad/staff_only.php'";
      } else {
        $_str = "　審査一覧に戻る　";
        $_codename = "location.href='./rv/index_Comment.php'";
      }
      $_msg .= "<INPUT type='button' name='' value='" . $_str . "' onclick=" . $_codename . ">";
      $_msg .= "</FORM>";
      $_msg .= "<BR>";
      break;
      
    case 4:
      // 幹事へ　*** conductSteps -> saveSteps -> _createPDF -> closeSteps ***
      $_msg = "<BR>　この審査処理は完了しました<BR>";
      $_msg .= "<BR>　　申請番号: " . $entryNo . " です<BR>";
      $_msg .= "<BR>";
      $_msg .= "<FORM>";
      switch ($backDisplay) {
        case 1:
          $_str = "　前画面に戻る　";
          $_codename = "location.href='./ad/showupByStatus.php?sCS=".$statusCodeShow."'";
          break;
        case 2:
          $_str = "　前画面に戻る　";
//          $_codename = "location.href='./ad/conductSteps.php?id=".$entryNo."&so=".$_staffOnly."&bD=".$backDisplay."&fy=".$fiscalYear."'";
          $_codename = "location.href='./ad/summarizeByYear.php?so=".$_staffOnly."&fy=".$fiscalYear."&od=".$OrderDisplay."'";
          break;
          
        default:
//          $_str = "　前画面に戻る　";
//          $_codename = "location.href='./ad/conductSteps.php?id=".$entryNo."&so=".$_staffOnly."'";
          $_str = "　管理に戻る　";
          $_codename = "location.href='./ad/staff_only.php'";
      }
      $_msg .= "<INPUT type='button' name='' value='" . $_str . "' onclick=" . $_codename . ">";
      $_msg .= "</FORM>";
      $_msg .= "<BR>";
      break;
      
    case 5:
      // 幹事へ　*** assignReviewer -> saveReviewer -> _createPDF -> remandForm ***
      $_msg = "<BR>　差戻しメールが申請者に送信されました<BR>";
      $_msg .= "<BR>　　申請番号: " . $entryNo . " です<BR>";
      $_msg .= "<BR>";
      $_msg .= "<FORM>";
      if ($_staffOnly) {
        if ($backDisplay==2) {
          $_str = "閉じる";
          $_codename = "window.close()";
        } else {
          $_str = "　管理に戻る　";
          $_codename = "location.href='./ad/staff_only.php'";
        }
      } else {
        $_str = "　前画面に戻る　";
        $_codename = "location.href='./ad/summarizeByYear.php?so=".$_staffOnly."&fy=".$fiscalYear."&od=".$OrderDisplay."'";
      }
      $_msg .= "<INPUT type='button' name='' value='" . $_str . "' onclick=" . $_codename . ">";
      $_msg .= "</FORM>";
      $_msg .= "<BR>";
      break;
      
    case 6:
      // 審査者へ　*** reviewComment -> saveComment ***      一時保存
      $_msg = "<BR>　入力データは保存されました。<BR>";
      $_msg .= "<BR>　　申請番号: " . $entryNo . " です<BR>";
      $_msg .= "<BR>";
      $_msg .= "<FORM>";
      if ($_staffOnly) {
        $_str = "　管理に戻る　";
        $_codename = "location.href='./ad/staff_only.php'";
      } else {
        $_str = "　審査一覧に戻る　";
        $_codename = "location.href='./rv/index_Comment.php'";
      }
      $_msg .= "<INPUT type='button' name='' value='" . $_str . "' onclick=" . $_codename . ">";
      $_msg .= "</FORM>";
      $_msg .= "<BR>";
      break;
      
    case 7:
      // 幹事へ　*** conductSteps -> saveSteps ***
      $_msg = "<BR>　この審査１への対応が実施されました<BR>";
      $_msg .= "<BR>　　申請番号: " . $entryNo . " です<BR>";
      $_msg .= "<BR>";
      $_msg .= "<FORM>";
      switch ($backDisplay) {
        case 1:
          $_str = "　前画面に戻る　";
          $_codename = "location.href='./ad/showupByStatus.php?sCS=".$statusCodeShow."'";
          break;
          
        case 2:
          $_str = "　前画面に戻る　";
          $_codename = "location.href='./ad/summarizeByYear.php?so=".$_staffOnly."&fy=".$fiscalYear."&od=".$OrderDisplay."'";
          break;
          
        default:
        $_str = "　管理に戻る　";
        $_codename = "location.href='./ad/staff_only.php'";
      }
      $_msg .= "<INPUT type='button' name='' value='" . $_str . "' onclick=" . $_codename . ">";
      $_msg .= "</FORM>";
      $_msg .= "<BR>";
      break;
      
    case 8:
      // 審査者へ　*** reviewComment -> saveComment ***
      $_msg = "<BR>　審査２の処理が実施され審査は終了しました<BR>";
      $_msg .= "<BR>　　申請番号: " . $entryNo . " です<BR>";
      $_msg .= "<BR>";
      $_msg .= "<FORM>";
      if ($_staffOnly) {
        $_str = "　管理に戻る　";
        $_codename = "location.href='./ad/staff_only.php'";
      } else {
        $_str = "　審査一覧に戻る　";
        $_codename = "location.href='./rv/index_Comment.php'";
      }
      $_msg .= "<INPUT type='button' name='' value='" . $_str . "' onclick=" . $_codename . ">";
      $_msg .= "</FORM>";
      $_msg .= "<BR>";
      break;
      
    case 30:
      // *** _staffOnly -> _summarizeByYear -> _mailSummary ***
      $_msg = "<BR>　処理を完了しました<BR>";
      $_msg .= "<BR>";
      $_msg .= "<FORM>";
      switch ($backDisplay) {
        case 2:
          $_str = "　前画面に戻る　";
          $_codename = "location.href='./ad/summarizeByYear.php?so=".$_staffOnly."&fy=".$fiscalYear."&od=".$OrderDisplay."'";
          break;
          
        default:
          $_str = "　管理に戻る　";
          $_codename = "location.href='./ad/staff_only.php'";
      }
      $_msg .= "<INPUT type='button' name='' value='" . $_str . "' onclick=" . $_codename . ">";
      $_msg .= "</FORM>";
      $_msg .= "<BR>";
      break;
      
    case 40:
    case 50:
      // *** _staffOnly -> _runCode -> _createPDF ***
      $_msg = "<BR>　処理を完了しました<BR>";
      $_msg .= "<BR>　　申請番号: " . $entryNo . " です<BR>";
      $_msg .= "<BR>";
      $_msg .= "<FORM>";
      if ($_staffOnly) {
        $_str = "　管理に戻る　";
        $_codename = "location.href='./ad/staff_only.php'";
      } else {
        $_str = "　ホームに戻る　";
        $_codename = "location.href='http://www.prc.tsukuba.ac.jp/papercheck/'";
      }
      $_msg .= "<INPUT type='button' name='' value='" . $_str . "' onclick=" . $_codename . ">";
      $_msg .= "</FORM>";
      $_msg .= "<BR>";
      break;
      
    case 41:
    case 51:
      // *** _staffOnly -> _runCode -> _createPDF ***
      $_msg = "<BR>　処理は対象が未定の為途中終了しました。<BR>";
      $_msg .= "<BR>";
      $_msg .= "<FORM>";
      if ($_staffOnly) {
        $_str = "　管理に戻る　";
        $_codename = "location.href='./ad/staff_only.php'";
      } else {
        $_str = "　ホームに戻る　";
        $_codename = "location.href='http://www.prc.tsukuba.ac.jp/papercheck/'";
      }
      $_msg .= "<INPUT type='button' name='' value='" . $_str . "' onclick=" . $_codename . ">";
      $_msg .= "</FORM>";
      $_msg .= "<BR>";
      break;
      
    default:
      $_msg = "<BR>　外部発表審査の仕組みで不具合が発生しました。<BR>";
      $_msg .= "<BR>　　fromNo: (" . $_fromNo . ") <BR>";
      $_msg .= "<FORM>";
      if ($_staffOnly) {
        $_str = "　管理に戻る　";
        $_codename = "location.href='./ad/staff_only.php'";
      } else {
        $_str = "　ホームに戻る　";
        $_codename = "location.href='http://www.prc.tsukuba.ac.jp/papercheck/'";
      }
      $_msg .= "<INPUT type='button' name='' value='" . $_str . "' onclick=" . $_codename . ">";
      $_msg .= "</FORM>";
      $_msg .= "<BR>";
      break;
      
  }
echo $_msg;

?>


</BODY>
</HTML>
