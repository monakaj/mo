<?php 

$dsn = 'mysql:dbname=�f�[�^�x�[�X��;host=localhost'; 
$user='���[�U�[��';
$password='�p�X���[�h';

//�f�[�^�x�[�X�ւ̐ڑ�
	$pdo = new PDO($dsn, $user, $password);
	print('�ڑ��ɐ������܂����B<br>');

//�e�[�u���쐬
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
