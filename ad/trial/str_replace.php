<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<TITLE>PRC_外部発表審査(申請)</TITLE>
</HEAD>

<BODY>
<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");


    $_dir = dirname( __FILE__ ) . '/ad/data/tmp/' . '1497237365' .'/';
    $_filename = '18thLAPD_abstract itagaki.pdf';
echo "    filename=(" . $_filename . ")<br>";    
    $_filename = str_replace(' ','_',$_filename);                              // ファイル名中の半角スペースをアンダースコアに置換える
    
//    move_uploaded_file($tmp_name, $uploads_file);
 

echo "new-filename=(" . $_filename . ")<br>";
?>


<BR>　この処理(keepFiles)は終了しました<BR>
<BR>
<FORM>
<INPUT type="button" name="" value="　戻る　" onclick="<?php echo $_str ?>">
</FORM>
<BR>

</BODY>
</HTML>
