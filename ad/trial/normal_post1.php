<META http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
var_dump($_FILES);

if($_FILES['file']){
//  print_r($_FILES['file']);
  move_uploaded_file($_FILES['file']['tmp_name'], './test.jpg');
}

?>


<form action="./normal_post1.php" method="POST" enctype="multipart/form-data">
<!--  <input type="file" name="file"> -->
  <input type="file" name="image_file[]" multiple="multiple">
  
  <input type="submit" value="ファイルをアップロードする">
</form>
