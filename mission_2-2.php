<?php

$dataFile='kadai2_2.txt';

$dataLine = file($dataFile);

if($_SERVER['REQUEST_METHOD']=='GET')
{

$id = sizeof($dataLine)+1;

$name =($_GET['name']); 

$comment = ($_GET['comment']); 

$time = date('H-i-s');

if($dataLine == false){
echo "if文動いています";
	$id = 1;
}

$newData= $id.'<>'.$name.'<>'.$comment.'<>'.$time."\n";

echo 	"$dataLineの中身";
echo "<pre>";
echo var_dump($dataLine);
echo "</pre>";

echo 	"$sizeof($dataLine)の値";
echo sizeof($dataLine);


$fp=fopen($dataFile,'a');
 fwrite($fp,$newData);
 fclose($fp);
}

$dataLine = file($dataFile);

echo "<pre>";
echo var_dump($dataLine);
echo "</pre>";

?>

<!DOCTYPE html>
<html>
<head>
<title>mission2-2</title>
</head>
<body>
 <form method="GET ">
  名前：<br />
  <input type="text" name="name"><br />
  コメント：<br />
  <textarea name="comment" cols="30" rows="5"></textarea><br />
  <br />
  <input type="submit" value="登録する" />
</form>

</body>
</html>
