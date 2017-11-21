<?php

touch('kadai2_6.txt');
$filename = 'kadai2_6.txt';
$dataLine = file($filename);


session_start();
if (!isset($_SESSION['id'])) {
  $_SESSION['id'] = 0;
}
if(isset($_POST['name'])){
	$_SESSION['id']++;
}

function convertIntoRn($string, $to = PHP_EOL){
    return strtr($string, array_fill_keys(array(","), $to));
}

//id,name,timeの定義
$id = $_SESSION['id'];
$name =($_POST['name']); 
$comment = ($_POST['comment']); 
$time = date('H-i-s');


//deleteIdの定義
$deleteId = $_POST['deleteId'];
//editIdの定義
$editId = $_POST["editId"];
$completeEditId = $_POST["completeEditId"];
//password の定義
$password = $_POST["password"];
$checkPassword = $_POST["checkPassword"];
//delete,editの確認パス定義
$checkEditPass = $_POST["checkEditPass"];
$checkDeletePass = $_POST["checkDeletePass"];
//delete処理の定義
$deleteProcess1 = $_POST['deleteProcess1'];
$deleteProcess2 = $_POST['deleteProcess2'];
$deleteProcess3 = $_POST['deleteProcess3'];



//delete,editの送信ボタンが押されたら、そのIdのパスワードを取得
if(isset($deleteId) or isset($editId)){

	foreach($dataLine as $key => $line){
		$setPass_data[] = explode("<>",$line);
		
		if($setPass_data[$key][0] == $deleteId){
			$getDeletePass = trim($setPass_data[$key][4]);
		}
		if($setPass_data[$key][0] == $editId){
			$getEditPass = trim($setPass_data[$key][4]);
		}
	}
}


if((isset($_POST['name']) && $password == $checkPassword) or (isset($_POST['passwordPermitting']))){

	$line ="{$id}<>{$name}<>{$comment}<>{$time}<>{$password}".PHP_EOL;

	$fp = fopen($filename, 'a');
	fwrite($fp, $line);
	fclose($fp);

}


if(isset($deleteId) && $getDeletePass == $checkDeletePass && isset($checkDeletePass)){

	$tempDataLine = file($filename);
	foreach($tempDataLine as $key => $line){
		$tempData[] = explode("<>",$line);

		if(!($tempData[$key][0] == $deleteId)){
			$delete_newLine.=$line;
		}
	}

	$fp = fopen($filename, 'w');
	fwrite($fp, $delete_newLine);
	fclose($fp);

	$deleteDone = "finish";
}

//データ受け取り
$dataLine = file($filename);


if(isset($editId) && $getEditPass == $checkEditPass){

	foreach($dataLine as $key => $line){
		$edit_data[] = explode("<>",$line);

		if($edit_data[$key][0] == $editId){
			$editProceed = "START";

			$default= array(
					"id"=>$edit_data[$key][0],
					"name"=>$edit_data[$key][1],
					"comment"=>convertIntoRn($edit_data[$key][2]),
					"time"=>$edit_data[$key][3],
					"password"=>trim($edit_data[$key][4])
					);
		}
	}
}

if(isset($completeEditId)){

	for($i=0;$i<count($dataLine)-1;$i++){
		$completeEdit_data[] = explode("<>",$dataLine[$i]);
		
		if($completeEdit_data[$i][0] == $completeEditId){

			$completeEdit_data[$i][1] = $name;
			$completeEdit_data[$i][2] = $comment;
			$completeEdit_data[$i][3] = $time;
			$completeEdit_data[$i][4] = $password.PHP_EOL;
		}

	$completeEdit_newLine.="{$completeEdit_data[$i][0]}<>{$completeEdit_data[$i][1]}<>{$completeEdit_data[$i][2]}<>{$completeEdit_data[$i][3]}<>{$completeEdit_data[$i][4]}";

	}
		$fp = fopen($filename,'w');
		fwrite($fp,$completeEdit_newLine);
		fclose($fp);
	
}


//データをもらう
$dataLine = file($filename);

if(!(count($dataLine) == 0)){

	//同じ名前コメント削除機能
	foreach($dataLine as $key => $line){
		$dataCheck[] = explode("<>",$line);

		if($tempName == $dataCheck[$key][1] && $tempComment == $dataCheck[$key][2]){
			continue;
		}
		$tempName = $dataCheck[$key][1];
		$tempComment = $dataCheck[$key][2];
		
		$newLine.=$line;
	}

	//データファイルに送る
	$fp = fopen($filename, 'w');
	fwrite($fp, $newLine);
	fclose($fp);
	//データファイルから受け取る
	$dataLine = file($filename);

	foreach($dataLine as $key => $line){
		$data[] = explode("<>",$line);
		//各行のコメンとを改行を反映させて$dataに格納
		$commentLine = explode(",",$data[$key][2]);//「,」ごとに配列に入れる
		foreach($commentLine as $value){
			$prepComment.= $value."<br>";
		}

		$data[$key][2]=$prepComment;
		unset($prepComment);
	}

	foreach($data as $key => $value){
		$array_id[] = $value[0];
		$array_name[] = $value[1];
		$array_comment[] = $value[2];
		$array_time[] = $value[3];
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>mission2</title>
	<meta charset="UTF-8">
</head>
<body>
	<div class="input">
		<h1>入力フォーム</h1>
		<form method="post">
			<?php if(isset($checkPassword) && $password != $checkPassword):?>
				<p>名前</p>
				<input type="text" name="name" value="<?php echo $name;?>" required>
				<p>コメント</p>
				<textarea name="comment" required><?php echo $comment;?></textarea>
				<p>パスワード</p>
				<input type="password" name="password" value="<?php echo $password;?>" required>
				<p>確認用パスワード</p>
				<p>パスワードがまちがっています！</p>
				<input type="password" name="checkPassword" required>
				<p><input type="submit"></p>
			<?php else: ?>
				<p>名前</p>
				<input type="text" name="name" required>
				<p>コメント</p>
				<textarea name="comment" required></textarea>
				<p>パスワード</p>
				<input type="password" name="password" required>
				<p>確認用パスワード</p>
				<input type="password" name="checkPassword" required>
				<p><input type="submit" name="passwordPermitting"></p>
			<?php endif ?>
		</form>
	</div>

	<div class="editt">
		<h1>編集番号指定フォーム</h1>
		<form method="post">
			<?php if(isset($editProceed)):?>
				<h2>編集内容</h2>
					<p>名前</p>
					<input type="hidden" name="completeEditId" value="<?php echo $default["id"]?>">
					<input type="text" name="name" required value="<?php echo $default["name"]?>">
					<p>コメント</p>
					<textarea name="comment" required><?php echo $default["comment"]?></textarea>
					<input type="hidden" name="password" value="<?php echo $default["password"]?>">
					<p><input type="submit" name = "passwordPermitting"></p>
			<?php elseif(isset($checkEditPass)):?>
				<p>パスワード</p>
				<p>パスワードが間違っています！<p>
				<input type="password" name="checkEditPass" required>
				<input type="hidden" name="editId" value="<?php echo $editId ?>">
				<p><input type="submit"></p>
			<?php elseif(isset($getEditPass)):?>
				<p>パスワード</p>
				<input type="password" name="checkEditPass" required>
				<input type="hidden" name="editId" value="<?php echo $editId ?>">
				<p><input type="submit"></p>
			<?php elseif(isset($editId)):?>
				<p>編集番号</p>
				<p>合致するIDがありません</p>
				<input type="number" name="editId" required>
				<p><input type="submit"></p>
			<?php else:?>
				<p>編集番号</p>
				<input type="number" name="editId" required>
				<p><input type="submit"></p>
			<?php endif?>
		</form>
	</div>

	<div class="output">
		
		<h1>コメント一覧</h1>
		<?php for($i=0;$i<count($data);$i++):?>
			<P><?php echo $array_time[$i];?></p>
			<P>id :<?php echo $array_id[$i];?></p>
			<P>名前 :<?php echo $array_name[$i];?></p>
			<P>コメント :<br><?php echo $array_comment[$i];?></p>
		<?php endfor?>

	</div>

	<div class="delete">
		<h1>削除フォーム</h1>
		<form method="post">
			<?php if(isset($getDeletePass) && empty($deleteDone) && isset($deleteProcess3)):?>
				<p>パスワードが間違っています！<p>
				<p>最初からやり直してください</p>
				<p>削除対象番号</p>
				<input type="number" name="deleteId" required>
				<input type="hidden" name = "deleteProcess1" value="go">
				<input type="submit">
			<?php elseif(isset($deleteProcess2) && isset($getDeletePass) && empty($deleteDone)):?>
				<p>パスワード</p>
				<p>パスワードが間違っています！<p>
				<input type="password" name="checkDeletePass" required>
				<input type="hidden" name="deleteId" value="<?php echo $deleteId ?>">
				<input type="hidden" name = "deleteProcess3" value="go">
				<p><input type="submit"></p>
			<?php elseif(isset($getDeletePass) && empty($deleteDone)):?>
				<p>パスワード</p>
				<input type="password" name="checkDeletePass" required>
				<input type="hidden" name="deleteId" value="<?php echo $deleteId ?>">
				<input type="hidden" name = "deleteProcess2" value="go">
				<p><input type="submit" name = "delete2"></p>
			<?php elseif(isset($deleteProcess1) && empty($deleteDone)):?>
				<p>削除対象番号</p>
				<p>対象番号が間違っています</p>
				<input type="number" name="deleteId" required>
				<input type="submit">
			<?php elseif(isset($deleteDone)):?>
				<p>削除が完了しました！<p>
				<p>削除対象番号</p>
				<input type="number" name="deleteId" required>
				<input type="hidden" name = "deleteProcess1" value="go">
				<input type="submit">
			<?php else:?>
				<p>削除対象番号</p>
				<input type="number" name="deleteId" required>
				<input type="hidden" name = "deleteProcess1" value="go">
				<input type="submit">
			<?php endif?>
		</form>
	</div>
</body>
</html>