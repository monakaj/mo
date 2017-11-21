<?php 

$dsn = 'mysql:データベース名;host=localhost'; 
$user='ユーザー名';
$password='パスワード';

//データベースへの接続
	$pdo = new PDO($dsn, $user, $password);
	print('接続に成功しました。<br>');

?>
