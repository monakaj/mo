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
 <h1>���̓t�H�[��</h1>
 <form method="GET ">
  ���O�F<br />
  <input type="text" name="name"><br />
  �R�����g�F<br />
  <textarea name="comment" cols="30" rows="5"></textarea><br />
  <br />
  <input type="submit" value="�o�^����" />
</form>

 <h1>���e���e</h1>
<?php
foreach($array as $key => $value){
    echo '<p><b>�ԍ�:</b>'.$array_id[$key].'<p>';
    echo '<p><b>���O:</b>'.$array_name[$key].'<p>';
    echo '<p><b>�R�����g:</b>'.$array_comment[$key].'<p>';
    echo $array_time[$key];
}
?>

</body>
</html>




