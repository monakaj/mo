<?php
//name,comment,time��`
$name = $_POST['name'];
//password��`
$password = $_POST['password'];
$checkPassword =$_POST['checkPassword'];



//�G�X�P�[�v�����̊֐�
function h($value){
	return htmlspecialchars(stripslashes($value),ENT_QUOTES);
}

function convert($comment){
	$comment = stripslashes($comment);
	$comment = htmlspecialchars($comment,ENT_QUOTES);
	return nl2br($comment);
}


//data�x�[�X���
$dbname = '�f�[�^�x�[�X��'; 
$host = 'localhost'; 
$user = '���[�U�[��';
$dbpassword = '�p�X���[�h';
$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
	//�f�[�^�x�[�X�ڑ�
	$pdo = new PDO($dns, $user, $dbpassword);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = 'select max(id) from users order by id desc';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	while($result = $stmt->fetch(PDO::FETCH_NUM)){
		$lastId = $result[0];
	}

	$sql = 'select name, comment from users  where id = :lastId';
	$stmt = $pdo->prepare($sql);
	$paramas = array('lastId'=>$lastId);
	$stmt->execute($paramas);

	while($result = $stmt->fetch(PDO::FETCH_NUM)){
		$lastName = $result[0];
		$lastComment = $result[1];