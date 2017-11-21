<?php
if(isset($_GET['message'])){
$message=$_GET['message'];
echo $message;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>mission1-4</title>
	<meta charset="UTF-8">
</head>
<body>
 <form method="GET ">
 <input type="text" name="message">
 <input type="submit" value="send">
 </form>
</body>
</html>
 

