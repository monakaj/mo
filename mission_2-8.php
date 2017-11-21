<?php 

$dsn = 'mysql:dbname=データベース名;host=localhost'; 
$user='ユーザー名';
$password='パスワード';

//データベースへの接続
	$pdo = new PDO($dsn, $user, $password);
	print('接続に成功しました。<br>');

//テーブル作成
	$sql = 'CREATE TABLE name
	(
		id INT(6) PRIMARY KEY,
		name CHAR(32) NOT NULL,
		comment VARCHAR(32),
		time TIMESTAMP
		PRIMARY KEY (id)
		)';
	$result=$pdo->query($sql);
	
	
?>
