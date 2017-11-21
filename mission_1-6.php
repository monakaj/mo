<?php
$message=$_GET['message']."\n";
if($message){
 $file=fopen('kadai6.txt','a');
 fwrite($file,$message);
 fclose($file);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>mission1-6</title>
	<meta charset="UTF-8">
</head>
<body>
 <form method="GET ">
 <input type="text" name="message">
 <input type="submit" value="send">
 </form>
</body>
</html>
