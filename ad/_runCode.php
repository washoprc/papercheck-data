<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<TITLE>PRC_外部発表審査(管理3)</TITLE>
</HEAD>

<BODY>

<?php
/*
var_dump($_POST);
*/

$cRow = $_POST['cRow'];
$entryNo = $_POST['entryNo'];
$codename = $_POST['codename'];
$chk_remand = $_POST['chk_remand'];
$_staffOnly = $_POST['so'];
  
  
  $backDisplay = 0;
  
  switch ($codename) {
    
    case "_createPDF.php":
      if ($chk_remand)
        $fn = 50;
      else
        $fn = 40;
      $_msg = "location: ./".$codename."?fn=".$fn."&so=".$_staffOnly."&cr=".(int)$cRow;
      break;
      
    default:
      $_msg = "location: ./".$codename."?id=".$entryNo."&so=".$_staffOnly."&bD=".$backDisplay;
      
  }
  
// echo "string=(".$_msg.")<br>";

header($_msg);
exit;

?>


</BODY>
</HTML>
