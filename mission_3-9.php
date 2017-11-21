<?php

// セッション開始
session_start();

//post定義
$signup = $_POST['signup'];
$userId = $_POST['userId'];
$userName = $_POST['userName'];
$password = $_POST['password'];
$passCheck = $_POST['passCheck'];

echo $signup."<br>";
echo $userName."<br>";
echo $password."<br>";
echo $passCheck."<br>";

//メール
$email = $_POST["email"];

//エラーメッセージの初期化
$errors = array();
$signupMessage = "";


//登録ボタンが押されたときの処理
if(isset($signup)){
echo "<p>if signup working</p>";

	//登録情報記入
	if(empty($_POST["confirmation"])){

		/*emailはrequireだから必ず入力されている
		if ($email == ''){
		//echo "<p> if empty email</p>";
			$errors['mail'] = "メールが入力されていません。";
		}else
		*/

		if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)){
			$errors['mail_check'] = "メールアドレスの形式が正しくありません。";
		//echo "<p>if preg_match</p>";
		}elseif($password != $passCheck){
			//パスワードが異なる場合のエラー表示
			$errors['password'] = "!パスワードが異なります!";
		//echo "<p>if password differ</p>";
		//echo $errors['password'];
		}else{
			$confirmation="confirmed";
			//sessionに入れとく
			$_SESSION[userName] = $userName;
			$_SESSION[password] = $password;
			$_SESSION[email] = $email;
	
		}
	}else{

	//確認画面
	echo "<p>confirmation, working</p>";
		
		//確認画面の下りでPOSTが消えたからもとに戻す
		$userName = $_SESSION[userName];
		$password = $_SESSION[password];
		$email = $_SESSION[email];

		//メールを日本語で送るための準備
		mb_language("Japanese");
		mb_internal_encoding("UTF-8");

		//ユニークなIDを生成
		$uniqueId = uniqid(rand());
		//urlを指定
		$url = "http://co-920.it.99sv-coco.com/signup_confirm.php?uniqueId=".$uniqueId;

		//メール送る準備

		$subject = "新規登録用URL";
		$message = "下記サイトにアクセスし、登録を完了させてください。\r\n".$url;

		//メール送信
		mb_send_mail($email,$subject,$message);



		//データベース接続
		try {
			require_once("db_info&connect.php");
	
			$sql = 'select max(id) from users order by id desc';
			$stmt = $dbh->prepare($sql);
			$stmt->execute();

			while($result = $stmt->fetch(PDO::FETCH_NUM)){
			$lastId = $result[0];
			}

			$sql = 'select name, comment from users  where id = :lastId';
			$stmt = $dbh->prepare($sql);
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



			//入力情報をデータベースにinsert
			$sql = 'insert into users (id,name,password,uniqueId,email,registered_time) values (?, ?, ?, ?, ?, now())';
			$stmt = $dbh->prepare($sql);
			$flag = $stmt->execute(array($id,$userName,$password,$uniqueId,$email));

			if($flag){
				echo 'データの追加に成功しました<br>';
			}else{
				echo 'データの追加に失敗しました<br>';
			}
/*
			//ユーザーIDを取得
			$userId = $dbh->lastinsertid();
			echo "userId : $userId<br>";
*/			

			//登録メッセージ
			$signupMessage = "メールを送信しました";
			echo "signupMessage : $signupMessage<br>";


		}catch(PDOException $e){
			echo('Connection failed:'.$e->getMessage());
			die();
		}
		
		//session破棄
		$_SESSION = array();
		session_destroy();
	}
}


echo "<p>erro:</p>";
echo var_dump($errors);


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
 	<title>新規登録</title>
	<link rel="stylesheet" href="style.css">

</head>
<body>
<?php require_once("top.php");?>
	<?php if(!empty($signupMessage)):?>
	<div class="signup-wrapper">
		<div class="signup-container">
			<div class="close-modal">
				<a href="main.php" class="fa fa-2x fa-times"></a>
			</div>
			<h3 class="signup-heading">完了</h3>
			<p class="email-info">メールを送信しました。<br>２４時間以内に<br>登録をお済ませください。</p>
		</div>
	</div>
	

	<?php elseif(!empty($confirmation)):?>
	<div class="signup-wrapper">
		<div class="signup-container">
			<div class="close-modal">
				<a href="main.php" class="fa fa-2x fa-times"></a>
			</div>
			<h3 class="signup-heading">確認</h3>
			<form action="" method="post">
				<p class="signup-info">username : <?php echo $userName;?></p>
				<p class="signup-info">email : <?php echo $email;?></p>
				<input type="hidden" name="confirmation" value ="confirmed">
				<input class="email-btn" type="submit" name="signup" value="メールを送信">
			</form>
		</div>
	</div>
	<?php else:?>
	<div class="signup-wrapper">
		<div class="signup-container">
			<div class="close-modal">
				<a href="main.php" class="fa fa-2x fa-times"></a>
			</div>
			<h3 class="signup-heading"><font face="メイリオ" color="dimgray">新規登録</font></h3>
			<form action="" method="post">
				<input class="signup-input" type="text" name="email" placeholder="email" required value="<?php echo $email ;?>"><br>
				<input class="signup-input" type="text" name="userName" placeholder="ユーザーネーム" required value="<?php echo $userName ;?>"><br>
				<input class="signup-input" type="password" name="password" placeholder="パスワード" required value="<?php echo $password ;?>"><br>
				<input class="signup-input" type="password" name="passCheck" placeholder="もう一度パスワード" required><br>
				<input class="signup-btn" type="submit" name="signup" value="登録">
			</form>
			<div class="warning">
				<?php foreach($errors as $error):?>
				<p><?php echo $error;?><p>
				<?php endforeach?>
			</div>
<p><a href="mission_3-7.php">すでに登録されている方はこちら</a></p>
		</div>
	</div>
	<?php endif?>
</body>
</html>
