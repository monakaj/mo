<?php 

$dsn = 'mysql:データベース名;host=localhost'; 
$user='ユーザー名';
$password='パスワード';

//データベースへの接続
	$pdo = new PDO($dsn, $user, $password);
	print('接続に成功しました。<br>');

//テーブル作成
	$sql = 'CREATE TABLE users
		(
		id INT(6) PRIMARY KEY,
		name CHAR(32) NOT NULL,
		comment VARCHAR(32),
		time TIMESTAMP
		PRIMARY KEY (id)
		)';
	$result=$pdo->query($sql);
	
//テーブル一覧を表示
	$sql = 'SHOW TABLES';
	$result = $pdo -> query($sql);
	foreach($result as $row){
	echo $row[0];
	 echo'<br>';



	echo 'rowの中身<pre>';
	echo var_dump($row);
	echo '</pre>';
	}

//テーブル中身を表示
	$sql = 'show create table users';
	$result = $pdo -> query($sql);
	foreach($result as $row){
	echo $row[1];
	 echo'<br>';



	echo 'rowの中身<pre>';
	echo var_dump($row);
	echo '</pre>';
}


?> 





