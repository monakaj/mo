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

//password追加
	$sql = "alter table users add password varchar(128) after time";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

//message追加
	$sql = "alter table users add message varchar(128) after password";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	
//userId追加
	$sql = "alter table users add userId INT(128) after message";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	
//image追加
	$sql = "alter table users add image mediumint(128) after userId";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	
//video追加
	$sql = "alter table users add video mediumint(128) after image";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	
//image追加
	$sql = "alter table users add img binary(128) after video";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	
	


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
	$params[] = array(':id'=>'5',':name'=>'rika',':comment'=>'hello',':password'=>'hello');
	$params[] = array(':id'=>'6',':name'=>'ayaka',':comment'=>'hello',':password'=>'hello');
	$params[] = array(':id'=>'7',':name'=>'aiai',':comment'=>'hello',':password'=>'hello');
	$params[] = array(':id'=>'8',':name'=>'mirei',':comment'=>'hello',':password'=>'hello');
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
	$params = array(':name'=>'hensyu','comment'=>'good night', 'id'=>6);
	$stmt->execute($params);

	if($params){
		echo 'データの編集に成功しました<br>';
	}else{
		echo 'データの編集に失敗しました<br>';
	}


//テーブルのデータ削除
	$sql = "delete from users  where id = :id";
	$stmt = $pdo->prepare($sql);
	$params = array('id'=>8);
	$stmt->execute($params);

	if($params){
		echo 'データの削除に成功しました<br>';
	}else{
		echo 'データの削除に失敗しました<br>';
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

	echo 'rowの中身<pre>';
	echo var_dump($parama);
	echo '</pre>';

//データ表示
	$sql = 'select id, name, comment,time,password,message,userId,image,video from practice';
	$result = $pdo -> query($sql);
	foreach($result as $row){
   		echo $row['id'] . " ,";
   		echo $row['name'] . ",";
		echo $row['comment'] . ",";
		echo $row['time'] . ",";
		echo $row['password'] . ",";
		echo $row['message'] . ",";
		echo $row['userId'] . ",";
		echo $row['image'] . ",";
		echo $row['video'] . "</br>";

}

?>





