<?php 

$dsn = 'mysql:データベース名;host=localhost'; 
$user='ユーザー名';
$password='パスワード';


//データベースへの接続
	$pdo = new PDO($dsn, $user, $password);
	print('接続に成功しました<br>');

//テーブル作成
	$sql = 'CREATE TABLE users
		(
		id INT(6) PRIMARY KEY,
		name CHAR(32) NOT NULL,
		comment VARCHAR(32),
		time TIMESTAMP
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

//テーブルにデータ挿入
$sql = 'insert into users (id,name,comment,time,password) values (:id, :name, :comment,now(),:password)';
	$result = $pdo -> query($sql);
	$params[] = array(':id'=>'1',':name'=>'rika',':comment'=>'hello',':password'=>'hello');
	$params[] = array(':id'=>'2',':name'=>'ayaka',':comment'=>'hello',':password'=>'hello');
	$params[] = array(':id'=>'3',':name'=>'aiai',':comment'=>'hello',':password'=>'hello');
	$params[] = array(':id'=>'4',':name'=>'mirei',':comment'=>'hello',':password'=>'hello');
	foreach($params as $parama){
	
	}
	if($parama){
		echo 'データの追加に成功しました<br>';
	}else{
		echo 'データの追加に失敗しました<br>';
	}
?> 





