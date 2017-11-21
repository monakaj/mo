<?php

session_start();



//ポスト定義
$name = $_POST['name'];
$message = $_POST['message'];
$comment = $_POST['comment'];
$time = date('Y/m/d H:i:s');
$deleteId = $_POST['deleteId'];
$editId = $_POST['editId'];
$editName = $_POST['editName'];
$editMessage = $_POST['editMessage'];
$editComment = $_POST['editComment'];

$completeEditId = $_POST['completeEditId'];
//file定義
$tempfile = $_FILES['file']['tmp_name'];
$filename = $_FILES['file']['name'];

$fileExtension = pathinfo($filename,PATHINFO_EXTENSION);

$imageExtensions = array("gif","jpg","jpeg","png","tif","tiff","bmp");
$videoExtensions = array("mp4","m4a");



//faleをサーバーにアップロード
if(is_uploaded_file($tempfile)){
	//拡張子をチェック、画像
	foreach($imageExtensions as $imageExtension){
		if($fileExtension == $imageExtension){
			if(move_uploaded_file($tempfile,"image/".$filename)){
			/*	echo $filename."をアップロードしました<br>";*/
				//$imageに画像のファイル名を入れる
				$image = $filename;
/*echo $image."<br>";:*/
			}else{
				/*echo "ファイルをアップロードできません<br>";*/
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
			/*	echo $filename."をアップロードしました<br>";*/
				//$videoに動画のファイル名を入れる
				$video = $filename;
			}else{
			/*	echo "ファイルをアップロードできません<br>";*/
			}
		}else{
			$i++;
		}
	}
	if(count($videoExtensions)==$i){
	/*	echo "拡張子が対応していません。<br>";*/
	}

}else{
/*	echo "ファイルが選択されていません。";*/
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

try {	//db接続
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

	//再読み込み防止
	if($name == $lastName && $comment == $lastComment){
		$samePost="reload";
	}

	//postが送られたときの動作
	if(isset($name) && empty($samePost)){

		//データベースに渡す
		$sql = "insert into practice (id,name,message,comment,time,userId,image,video) values (:id,:name,:message,:comment,:time,:userId,:image,:video)";
		$stmt = $dbh->prepare($sql);
		$paramas = array(':id'=>$_SESSION['id'],':name'=>$name,':message'=>$message,':comment'=>$comment,':time'=>$time,':userId'=>$_SESSION['userId'],':image'=>$image,':video'=>$video);
		$flag = $stmt->execute($paramas);
echo $image;
		if($flag){
		/*	echo 'データの追加に成功しました<br>';*/
		}else{
		/*	echo 'データの追加に失敗しました<br>';*/
		}
	}
	
	//deleteの処理
	if(isset($deleteId)){
		$sql = 'delete from practice where id = :deleteId';
		$stmt = $dbh->prepare($sql);
		$paramas = array(':deleteId'=>$deleteId);
		$stmt->execute($paramas);
		
//		echo "<h2>delete done successfully in DB</h2>";

	}elseif(isset($deleteId)){
		$falsePass = "false";
	}

	//edit処理
	if(isset($editComment)){
		$sql = "update practice set name = :name,message=:message, comment = :comment, time = :time where id = :id";
		$stmt = $dbh->prepare($sql);
		$params = array(':name'=>$editName,':message'=>$editMessage,':comment'=>$editComment,':time'=>$time,':id'=>$completeEditId);
		$stmt->execute($params);
//		echo '<h4>edit done successfully</h4>';		
	}
	

	//データの受け取り
	$sql ="select * from practice order by id";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();

	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$data[]= $result;
		$array_id[] = $result['id'];
		$array_name[] = $result['name'];
		$array_message[] = $result['message'];
		$array_comment[] = $result['comment'];
		$array_time[] = $result['time'];
		$array_userId[] = $result['userId'];
		$array_image[] = $result['image'];
		$array_video[] = $result['video'];
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
	<title>main</title>
	<link rel="stylesheet" href="center.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

</head>

<body>
<span style="background-color:pink"><a href="top.php">トップ画面へ</a></span>
<span style="background-color:pink"><a href="mission_3-9.php">新規登録画面へ</a></span>
<span style="background-color:pink"><a href="mission_3-7.php">ログイン画面へ</a></span>
<span style="background-color:pink"><a href="main.php">メイン画面へ</a></span>
<span style="background-color:pink"><a href="logout1.php">ログアウト画面へ</a></span>

<div style="background: url(07.jpg);">
 <h1><font face="メイリオ" color="white">旅行先の思い出をシェアしよう</font></h1>
</div>

<p>どこに旅行にいきましたか？旅行した地名、旅行の感想・一言コメント、画像か動画を投稿しよう！</p>
<p><font color=red>＊</font>は必須事項です。</p>

</br>
<div class="container">
			<div class="header-left">
				
			</div>
			<div class="header-right">
			</div>
		</div>
	</header>

	<div class ="post-wrapper">
		<div = "container">
				<form action="" method="post" enctype="multipart/form-data">
				<div class="parent1"><p class="child1">　　ユーザー名<font color=red>　＊</font></p></div>
				<input type="text" name="name" value ="<?php echo $_SESSION['name'];?>">
				<div class="parent1"><p class="child1">　　旅行先<font color=red>　＊</font></p></div>
				<textarea name="message"></textarea>
				<div class="parent1"><p class="child1">　　コメント<font color=red>　＊</font></p></div>
				<textarea name="comment"></textarea>
				<div class="parent1"><p class="child1"> 　　画像・動画のアップロード</p></div>
				<input type="file" name="file" id="file"></br>
</br>
</br>
				<input type="submit" value="送信する">
			</form>

		</div>
		</div>
	</div>


	<div class ="contents-wrapper">
		<div class="container">
			<div class="heading">
<div style="background: url(07.jpg);">
	 <h1><font face="メイリオ" color="white">みんなの投稿</font></h1>
</div>			
		</div>
			<?php for($i=0;$i<count($data);$i++):?>
				<hr style="border:0;border-top:1px solid silver;">

				
				<div class="comments">
					<?php if($editId == $array_id[$i]):?>
						<form class="edit-form" method="post">
							<p class="id"><?php echo $array_id[$i];?></p>
							<input type="hidden" value="<?php echo $array_id[$i];?>" name="completeEditId">
							<input class="editName" type="text" value="<?php echo h($array_name[$i]);?>" name="editName" required>
							<p class="time"><?php echo $array_time[$i];?></p>
							<textarea class="message" name="editMessage" required><?php echo h($array_message[$i]);?></textarea></br>
							<textarea class="comment" name="editComment" required><?php echo h($array_comment[$i]);?></textarea></br>
							<input class="edit-input" type="submit" value="送信する">
						</form>
					<?php else:?>
						<p class="id"><font color="gray">ユーザーID:　</font><?php echo h($array_id[$i]);?></p>
						<p class="name"><font color="gray">ユーザー名:　</font><?php echo h($array_name[$i]);?></p>
						<p class="time"><font color="gray">投稿日時:　</font><?php echo $array_time[$i];?></p>
						<p class="message"><font color="gray">旅行先:　</font><?php echo convert($array_message[$i]);?></p>
						<p class="comment"><font color="gray">コメント:　</font><?php echo convert($array_comment[$i]);?></p>
						<?php if(!empty($array_image[$i])):?>	
							<img src="<?php echo "image/".$array_image[$i];?>">
						<?php endif ?>
						<?php if(!empty($array_video[$i])):?>
							<video autoplay loop muted controls>
								<source src="video/<?php echo $array_video[$i] ;?>">
							</video>
						<?php endif?>
					<?php endif?>
				</div>
				<?php if($_SESSION['userId'] == $array_userId[$i]):?>
				<div class="btns">
					<form class="btn-form" method="post">
						<div class="btn-option">
							<button type="button" class="delete-open">削除する</button>
							<button type="submit" class="edit btn" value="<?php echo $array_id[$i];?>" name="editId">編集する</button>
						</div>
						<div class="delete-alarm">
							<p>本当に削除しますか？</p>
							<button type="submit" class="delete btn" value="<?php echo $array_id[$i];?>" name="deleteId">YES</button>
							<button type="button" class="btn delete-close">NO</button>
						</div>
					</form>
				</div>
				<div class="warning">
					<?php if(isset($falsePass) && ($deleteId == $array_id[$i] or $editId == $array_id[$i])):?>
						<p>your password was wrong</p>
					<?php endif?>
				</div>
				<?php endif ?>
			<?php endfor?>
		</div>
	</div>

	<footer>
	</footer>
	<script src="script_main.js"></script>
</body>
</html>