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

//�e�[�u�����g��\��
	$sql = 'show create table users';
	$result = $pdo -> query($sql);
	foreach($result as $row){
	echo $row[1];
	 echo'<br>';

	echo 'row�̒��g<pre>';
	echo var_dump($row);
	echo '</pre>';
}

//�e�[�u���Ƀf�[�^�}��
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
?> 





