<?php 

$dsn = 'mysql:�f�[�^�x�[�X��;host=localhost'; 
$user='���[�U�[��';
$password='�p�X���[�h';


//�f�[�^�x�[�X�ւ̐ڑ�
	$pdo = new PDO($dsn, $user, $password);
	print('�ڑ��ɐ������܂����B<br>');

//�e�[�u���쐬
	$sql = 'CREATE TABLE users
		(
		id INT(6) PRIMARY KEY,
		name CHAR(32) NOT NULL,
		comment VARCHAR(32),
		time TIMESTAMP
		password CHAR(32) NOT NULL,
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
?> 





