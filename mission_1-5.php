<?php
$message=$_GET['message'];
if($message){
 $file=fopen('kadai5.txt','w');
 fwrite($file,$message);
 fclose($file);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>mission1-5</title>
	<meta charset="UTF-8">
</head>
<body>
 <form method="GET ">
 <input type="text" name="message">
 <input type="submit" value="send">
 </form>
</body>
</html>
