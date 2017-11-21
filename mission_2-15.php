<?php
//name,comment,time定義
$name = $_POST['name'];
$comment = $_POST['comment'];
$time = date('Y/m/d H:i:s');
//password定義
$password = $_POST['password'];
$checkPassword =$_POST['checkPassword'];
//delete定義
$deleteId = $_POST['deleteId'];
$deleteRequire = $_POST['deleteRequire'];
$deletePass = $_POST['deletePass'];
//edit定義
$editId = $_POST['editId'];
$editRequire = $_POST['editRequire'];
$editPass = $_POST['editPass'];
$editName = $_POST['editName'];
$editComment = $_POST['editComment'];
$completeEditId = $_POST['completeEditId'];


//エスケープ処理の関数
function h($value){
	return htmlspecialchars(stripslashes($value),ENT_QUOTES);
}

function convert($comment){
	$comment = stripslashes($comment);
	$comment = htmlspecialchars($comment,ENT_QUOTES);
	return nl2br($comment);
}


//dataベース情報
$dbname = 'データベース名'; 
$host = 'localhost'; 
$user = 'ユーザー名';
$dbpassword = 'パスワード';
$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

try {
	//データベース接続
	$pdo = new PDO($dns, $user, $dbpassword);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
/*	if ($pdo == null) {
		echo'接続失敗<br>';
	} else {
		echo'接続成功<br>';
	}
*/


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
	}

	//idに１をたす
	if(empty($lastId)){
		$id=1;
	}else{
		$id=$lastId +1;
	}

	//再読み込み防止
	if($name == $lastName && $comment == $lastComment){
		$samePost="reload";
	}

	//postが送られたときの動作
	if(isset($name) && empty($samePost)){
		if($password == $checkPassword){

			//データベースに渡す
			$sql = "insert into users (id,name,comment,time,password) values (:id,:name,:comment,:time,:password)";
			$stmt = $pdo->prepare($sql);
			$paramas = array(':id'=>$id,':name'=>$name,':comment'=>$comment,':time'=>$time,':password'=>$password);
			$flag = $stmt->execute($paramas);

/*			if($flag){
				echo 'データの追加に成功しました<br>';
			}else{
				echo 'データの追加に失敗しました<br>';
			}
*/
		}else{
			$differentPass = "not same";
		}
	}
	
	//deleteの処理
	if(isset($deleteId) && $deletePass == $password){
		$sql = 'delete from users where id = :deleteId';
		$stmt = $pdo->prepare($sql);
		$paramas = array(':deleteId'=>$deleteId);
		$stmt->execute($paramas);
		
//		echo "<h2>delete done successfully in DB</h2>";
	}elseif(isset($deleteId)){
		$falsePass = "false";
	}

	//editのパスワードチェック
	if(isset($editId) && $editPass == $password){
		$allowEdit = "correct";
	}elseif(isset($editId)){
		$falsePass = "false";
	}

	//edit処理
	if(isset($editName)){
		$sql = "update users set name = :name, comment = :comment, time = :time where id = :id";
		$stmt = $pdo->prepare($sql);
		$params = array(':name'=>$editName,':comment'=>$editComment,':time'=>$time,':id'=>$completeEditId);
		$stmt->execute($params);
//		echo '<h4>edit done successfully</h4>';		
	}
	

	//データの受け取り
	$sql ="select * from users order by id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();

	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$data[]= $result;
		$array_id[] = $result['id'];
		$array_name[] = $result['name'];
//		$array_comment[] = replace(nl2br($result['comment']));
		$array_comment[] = $result['comment'];
		$array_time[] = $result['time'];
		$array_password[] = $result['password'];
	}

}catch(PDOException $e){
	echo('Connection failed:'.$e->getMessage());
	die();
}


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>2-15</title>
	<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
	<header>
	</header>
	<div class ="post-wrapper">
		<div = "container">
			<form action="" method="post">
				<?php if(empty($differentPass)):?>
					<p class="post-name ">NAME</p><input type="text" name="name">
					<p class="post-comment">COMMENT</p><textarea name="comment"></textarea>
					<p class="post-password">password</p><input type="password" name="password">
				<?php else:?>
					<p>NAME</p><input type="text" name="name" value="<?php echo $name ;?>">
					<p>COMMENT</p><textarea name="comment"><?php echo $comment;?></textarea>
					<p>password</p><input type="password" name="password" value="<?php echo $password ;?>">
					<p>different passwords!<p>
				<?php endif?>
				<p class="post-checkpass">check your password</p><input type="password" name="checkPassword"><br>
				<input type="submit" value="send">
			</form>
		</div>
	</div>

	<div class ="contents-wrapper">
		<div class="container">
			<div class="heading">
				<h1>message board</h1>
			</div>
			<?php for($i=0;$i<count($data);$i++):?>
				
				<div class="comments">
					<?php if(isset($allowEdit) && $editId == $array_id[$i]):?>
						<form class="edit-form" method="post">
							<p class="id"><?php echo $array_id[$i];?></p>
							<input type="hidden" value="<?php echo $array_id[$i];?>" name="completeEditId">
							<input class="editName" type="text" value="<?php echo h($array_name[$i]);?>" name="editName" required>
							<p class="time"><?php echo $array_time[$i];?></p>
							<textarea class="comment" name="editComment" required><?php echo h($array_comment[$i]);?></textarea>
							<input class="edit-input" type="submit" value="send">
						</form>
					<?php else:?>
						<p class="id"><?php echo $array_id[$i];?></p>
						<p class="name"><?php echo h($array_name[$i]);?></p>
						<p class="time"><?php echo $array_time[$i];?></p>
						<p class="comment"><?php echo convert($array_comment[$i]);?></p>
					<?php endif?>
				</div>
				<div class="btns">
					<form class="btn-form" method="post">
						<?php if(isset($deleteRequire) && $deleteRequire==$array_id[$i]):?>
							<p class="p1">please enter your password</p><input type="password" name="deletePass">
							<input type="hidden" name="password" value="<?php echo $array_password[$i];?>">
							<button type="submit" class="delete btn" value="<?php echo $array_id[$i];?>" name="deleteId">send</button>
						<?php elseif(isset($editRequire) && $editRequire == $array_id[$i]):?>
							<p class="p1">Please enter your password</p><input type="password" name="editPass">
							<input type="hidden" name="password" value="<?php echo $array_password[$i];?>">
							<button type="submit" class="delete btn" value="<?php echo $array_id[$i];?>" name="editId">send</button>
						<?php elseif(isset($allowEdit) && $editId == $array_id[$i]):?>
							<input type="hidden" class ="btn-input">
						<?php else:?>
							<button type="submit" class="delete btn" value="<?php echo $array_id[$i];?>" name="deleteRequire">delete</button>
							<button type="submit" class="edit btn" value="<?php echo $array_id[$i];?>" name="editRequire">edit</button>
						<?php endif ?>
					</form>
				</div>
				<div class="warning">
					<?php if(isset($falsePass) && ($deleteId == $array_id[$i] or $editId == $array_id[$i])):?>
						<p>your password was wrong</p>
					<?php endif?>
				</div>
			<?php endfor?>
		</div>
	</div>

	<footer>
	</footer>
</body>
</html>
