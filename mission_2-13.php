<?php 

$dsn = 'mysql:�f�[�^�x�[�X��;host=localhost'; 
$user='���[�U�[��';
$password='�p�X���[�h';

//�f�[�^�x�[�X�ւ̐ڑ�
	$pdo = new PDO($dsn, $user, $password);
	print('�ڑ��ɐ������܂���<br>');

//�e�[�u���쐬
	$sql = 'CREATE TABLE users
		(
		id INT(6) PRIMARY KEY,
		name CHAR(32) NOT NULL,
		comment VARCHAR(32),
		time TIMESTAMP
		PRIMARY KEY (id)
		)';
	$result=$pdo->query($sql);
	
//�e�[�u���ꗗ��\��
	$sql = 'SHOW TABLES';
	$result = $pdo -> query($sql);
	foreach($result as $row){
	echo $row[0];
	 echo'<br>';

	echo 'row�̒��g<pre>';
	echo var_dump($row);
	echo '</pre>';
	}

//�e�[�u���̒��g��\��
	$sql = 'show create table users';
	$result = $pdo -> query($sql);
	foreach($result as $row){
	echo $row[1];
	 echo'<br>';

	echo 'row�̒��g<pre>';
	echo var_dump($row);
	echo '</pre>';
}

//�e�[�u���Ƀf�[�^�ǉ�
	$sql = 'insert into users (id,name,comment,time,password) values (:id, :name, :comment,now(),:password)';
	$result = $pdo -> query($sql);
	$params[] = array(':id'=>'1',':name'=>'rika',':comment'=>'hello',':password'=>'hello');
	$params[] = array(':id'=>'2',':name'=>'ayaka',':comment'=>'hello',':password'=>'hello');
	$params[] = array(':id'=>'3',':name'=>'aiai',':comment'=>'hello',':password'=>'hello');
	$params[] = array(':id'=>'4',':name'=>'mirei',':comment'=>'hello',':password'=>'hello');
	foreach($params as $parama){
	
	}
	if($parama){
		echo '�f�[�^�̒ǉ��ɐ������܂���<br>';
	}else{
		echo '�f�[�^�̒ǉ��Ɏ��s���܂���<br>';
	}
//�e�[�u���̃f�[�^�ҏW
	$sql = "update users set name = :name, comment = :comment where id = :id";
	$stmt = $pdo->prepare($sql);
	$params = array(':name'=>'hensyu','comment'=>'good night', 'id'=>1);
	$stmt->execute($params);

	if($params){
		echo '�f�[�^�̕ҏW�ɐ������܂���<br>';
	}else{
		echo '�f�[�^�̕ҏW�Ɏ��s���܂���<br>';
	}

//�f�[�^�\��
	$sql = 'select id, name, comment,time from users';
	$result = $pdo -> query($sql);
	foreach($result as $row){
   		echo $row['id'] . " ,";
   		echo $row['name'] . ",";
		echo $row['comment'] . ",";
		echo $row['time'] . "<br>";
}
?>





