<?php
session_start();

if(isset($_POST['id'])){
    $_SESSION['id'] = $_POST['id'];
   }

?>
<?php
//name,comment,time定義
$name = $_POST['name'];
//password定義
$password = $_POST['password'];
$checkPassword =$_POST['checkPassword'];


$fileExtension = pathinfo($filename,PATHINFO_EXTENSION);

$imageExtensions = array("gif","jpg","jpeg","png","tif","tiff","bmp");
$videoExtensions = array("mp4","m4a");



//faleをサーバーにアップロード
if(is_uploaded_file($tempfile)){
	//拡張子をチェック、画像
	foreach($imageExtensions as $imageExtension){
		if($fileExtension == $imageExtension){
			if(move_uploaded_file($tempfile,"image/".$filename)){
				echo $filename."をアップロードしました<br>";
				//$imageに画像のファイル名を入れる
				$image = $filename;
echo $image."<br>";
			}else{
				echo "ファイルをアップロードできません<br>";
			}
		}else{
			$i++;
		}
	}
	if(count($videoExtensions)==$i){
		echo "拡張子が対応していません。<br>";
	}
	$i=0;

	//拡張子をチェック、動画
	foreach($videoExtensions as $videoExtension){
		if($fileExtension == $videoExtension){
			if(move_uploaded_file($tempfile,"video/".$filename)){
				echo $filename."をアップロードしました<br>";
				//$videoに動画のファイル名を入れる
				$video = $filename;
			}else{
				echo "ファイルをアップロードできません<br>";
			}
		}else{
			$i++;
		}
	}
	if(count($videoExtensions)==$i){
		echo "拡張子が対応していません。<br>";
	}

}else{
	echo "ファイルが選択されていません。";
}



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
	
	//postが送られたときの動作
	if(isset($name) && empty($samePost)){

		//データベースに渡す
		$sql = "insert into users (id,name,message,comment,time,image,video) values (:id,:name,:message,:comment,:time,:image,:video)";
		$stmt = $dbh->prepare($sql);
		$paramas = array(':id'=>$id,':name'=>$name,':messsage'=>$message,':comment'=>$comment,':time'=>$time,':image'=>$image,':video'=>$video);
		$flag = $stmt->execute($paramas);
echo $image;
		if($flag){
			echo 'データの追加に成功しました<br>';
		}else{
			echo 'データの追加に失敗しました<br>';
		}
	}
	
	

	//データの受け取り
	$sql ="select * from users order by id";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();

	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$data[]= $result;
		$array_id[] = $result['id'];
		$array_name[] = $result['name'];
		$array_message[] = $result['message'];
		$array_comment[] = $result['comment'];
		$array_image[] = $result['image'];
		$array_video[] = $result['video'];
	}


	}catch(PDOException $e){
		echo('Connection failed:'.$e->getMessage());
		die();
	}
}


?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>welcome</title>
  </head>
  <body>
  <h1>welcome</h1>
 <h1>旅行先の思い出をシェアしよう!(^^)!</h1>
 <form method="POST">
  名前：<br />
  <input type="text" name="name" value="<?php echo $_SESSION['name'];?>"><br />
  旅行先：<br />
  <textarea name="message" cols="30" rows="1"></textarea><br />
  コメント：<br />
  <textarea name="comment" cols="30" rows="5"></textarea><br />
  画像・動画のアップロード：<br />
　<input type="file" name="file" id="file"> <br />
  <input type="submit" value="送信する" />
</form>
		
		<h1>みんなの投稿</h1>
　						投稿日時：<?php echo $array_time[$i];?></br>
						<?php echo $array_id[$i];?></p>
						ユーザー名：<?php echo h($array_name[$i]);?></br>
						旅行先：<?php echo convert($array_message[$i]);?></br>
						コメント：<?php echo convert($array_comment[$i]);?></br>
						<?php if(!empty($array_image[$i])):?>	
							<img src="<?php echo "image/".$array_image[$i];?>">
						<?php endif ?>
						<?php if(!empty($array_video[$i])):?>
							<video autoplay loop muted controls>
								<source src="video/<?php echo $array_video[$i] ;?>">
							</video>
						<?php endif?>

							

<p><a href="logout.php">ログアウト画面へ</a></p>
  </body>
</html>


