<?php
$file='kadai2_2.txt';
$array=@file($file); 

foreach($array as $value){

$data=explode('<>',$value);

$array_id[]=$data[0];
$array_name[]=$data[1];
$array_comment[]=$data[2];
$array_time[]=$data[3];

}
?>

<!DOCTYPE html>
<html>
<head>
<title>mission2-1</title>
</head>
<body>
 <h1>入力フォーム</h1>
 <form method="GET ">
  名前：<br />
  <input type="text" name="name"><br />
  コメント：<br />
  <textarea name="comment" cols="30" rows="5"></textarea><br />
  <br />
  <input type="submit" value="登録する" />
</form>

 <h1>投稿内容</h1>
<?php
foreach($array as $key => $value){
    echo '<p><b>番号:</b>'.$array_id[$key].'<p>';
    echo '<p><b>名前:</b>'.$array_name[$key].'<p>';
    echo '<p><b>コメント:</b>'.$array_comment[$key].'<p>';
    echo $array_time[$key];
}
?>

</body>
</html>




