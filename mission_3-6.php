<?php
//name,comment,time定義
$name = $_POST['name'];
//password定義
$password = $_POST['password'];
$checkPassword =$_POST['checkPassword'];



//エスケープ処理の関数
function h($value){
	return htmlspecialchars(stripslashes($value),ENT_QUOTES);
}

function convert($comment){
	$comment = stripslashes($comment);
	$comment = htmlspecialchars($comment,ENT_QUOTES);
	return nl2br($comment);
}


//dataベース情報
$dbname = 'データベース名'; 
$host = 'localhost'; 
$user = 'ユーザー名';
$dbpassword = 'パスワード';
$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
	//データベース接続
	$pdo = new PDO($dns, $user, $dbpassword);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = 'select max(id) from users order by id desc';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	while($result = $stmt->fetch(PDO::FETCH_NUM)){
		$lastId = $result[0];
	}

	$sql = 'select name, comment from users  where id = :lastId';
	$stmt = $pdo->prepare($sql);
	$paramas = array('lastId'=>$lastId);
	$stmt->execute($paramas);

	while($result = $stmt->fetch(PDO::FETCH_NUM)){
		$lastName = $result[0];
		$lastComment = $result[1];