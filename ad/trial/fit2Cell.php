
<?php
//言語設定、内部エンコーディングを指定
mb_language("Japanese");
mb_internal_encoding("UTF-8");


$abstract = "非等方イオン温度を導入した空間一次元流体モデルによるダイバータプラズマシミュレーション結果を等方イオン温度による流体モデルと粒子モデルの結果と比較する。";
echo "test-->(" . fit2Cell($abstract, 38) . ")<br>";



function fit2Cell($string, $maxlen) {
  // 改行記号があれば生かす
  // 行最大文字数になったら改行する

  echo "string =(" . $string . ")<br>";
  echo "maxLen=(" . $maxlen . ")<br>";
  
  $str = str_split($string, $maxlen*2);
  
  print_r($str);
  
  return true;
}



?>

