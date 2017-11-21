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

//テーブルの中身を表示
	$sql = 'show create table users';
	$result = $pdo -> query($sql);
	foreach($result as $row){
	echo $row[1];
	 echo'<br>';

	echo 'rowの中身<pre>';
	echo var_dump($row);
	echo '</pre>';
}

//テーブルにデータ追加
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
//テーブルのデータ編集
	$sql = "update users set name = :name, comment = :comment where id = :id";
	$stmt = $pdo->prepare($sql);
	$params = array(':name'=>'hensyu','comment'=>'good night', 'id'=>1);
	$stmt->execute($params);

	if($params){
		echo 'データの編集に成功しました<br>';
	}else{
		echo 'データの編集に失敗しました<br>';
	}

//データ表示
	$sql = 'select id, name, comment,time from users';
	$result = $pdo -> query($sql);
	foreach($result as $row){
   		echo $row['id'] . " ,";
   		echo $row['name'] . ",";
		echo $row['comment'] . ",";
		echo $row['time'] . "<br>";
}
?>





