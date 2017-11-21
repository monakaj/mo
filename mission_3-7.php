
<?php


session_start();

if(isset($_POST['id'])){
    $_SESSION['id'] = $_POST['id'];
}

if(isset($_POST['password'])){
    $_SESSION['password'] = $_POST['password'];
}

//dataベース情報
$dbname = 'データベース名';
$host = 'localhost'; 
$user = 'ユーザー名';
$dbpassword = 'パスワード';
$dns = 'mysql:dbname='.$dbname.';host='.$host.';charset=utf8';

//post定義
$id=$_POST[id];
$password=$_POST[password];
$login=$_POST[login];


//エラーメッセージの初期化
$errorMessage="";

if(isset($login)){
	
	try {
		$dbh = new PDO($dns, $user, $dbpassword);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		if ($dbh == null) {
			echo'connection failed<br>';
		} else {
			echo'connection succeed<br>';
		}
	
		//投稿されたidの情報をselect
		$sql = 'select name, password from users  where id = :id';
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array(':id'=>$id));

		while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$userName = $result['name'];
			$userPass = $result['password'];
		}

		//投稿passとユーザーpassの比較
		if($password == $userPass){
			//セッションにユーザーネームを持たせる
			$_SESSION['name'] = $userName;
			//メイン画面へ
			header("Location: main.php");
			//処理終了
			exit();
		}else{
			$errorMessage="idあるいはpasswordが間違っています";
		}

	}catch(PDOException $e){
		echo('Connection failed:'.$e->getMessage());
		die();
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
</head>
<body>
<?php require_once("top.php");?>
<div class="a">
	<div class="login-wrapper">
		<div class="login-container">
			<div class="login-form">
				<h2 class="login-heading"><font face="メイリオ" >ログイン</font></h2>
				<form method="post">
					<input class="login-input" type="text" name="id" value="<?php echo $_SESSION['id']; ?>" required placeholder="id"><br>
					<input class="login-input" type="password" name="password" value="<?php echo $_SESSION['password']; ?>" required placeholder="password"><br>
					<input class="input-btn" type="submit" name="login" value="ログインする">
				</form>
			</div>
</br>
　<a href="top.php">トップに戻る</a>
</br>
</br>
			<?php if(!empty($errorMessage)):?>
			<div class="login-warring">
				<p>ユーザーidあるいはパスワードが間違っています</p>
			</div>
			<?php endif?>
		</div>
	</div>
</div>
</body>
</html>


