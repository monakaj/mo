<?php

$dataFile='kadai2_5.txt';
touch($dataFile);
$dataLine = file($dataFile);

$name =($_POST['name']); 
$comment = ($_POST['comment']); 
$time = date('H-i-s');

$completeEditId= $_POST['completeEditId'];


if(isset($dataLine)){
	$lastLine = explode('<>',$dataLine[count($dataLine)-1]);

	$lastId = $lastLine[0];

	if($lastLine[1] == $name && $lastLine[2] == $comment){
		$samePost = "reload";
	}

}

// && empty($completeEditId)を付け足します。編集の投稿を新しい情報として追記させないためです。
if(isset($name) && empty($samePost) && empty($completeEditId)){


	if(empty($lastId)){
		$id = 1;
	}else{
		$id = $lastId + 1;
	}

	$newData= $id.'<>'.$name.'<>'.$comment.'<>'.$time."\n";

	$fp=fopen($dataFile,'a');
	 fwrite($fp,$newData);
	 fclose($fp);
}



if(isset($_POST['delete'])){
	$delete= $_POST['delete'];

	$array = file($dataFile);

	foreach($array as $line){
		if(!($line[0] == $delete)){
			 $newLine.= $line;
		}
	}

	$fp=fopen($dataFile,'w');
	fwrite($fp,$newLine);
	fclose($fp);
}


if(isset($_POST['edit'])){
	$edit= $_POST['edit'];

	$array = file($dataFile);

	foreach($array as $line){
	$line=explode('<>',$line);
		if(($line[0] == $edit)){
		$default['id']=$line[0];
	    	$default['name']=$line[1];
		$default['comment']=$line[2];
		}
	}

}

if(!empty($_POST['completeEditId'])){

	foreach($dataLine as $line){
		$data=explode('<>',$line);

		if($data[0]== $completeEditId){
//			 
			 $edit_newLine.="$completeEditId<>$name<>$comment<>$time\r\n";
		}else{
			 $edit_newLine.=$line;
		}
	}

	$fp=fopen($dataFile,'w');
	fwrite($fp,$edit_newLine);
	fclose($fp);
}


//ここで削除や編集が行われた後のテキストファイルを読み込みます。
$dataLine = file($dataFile);

foreach($dataLine as $value){
	$data=explode('<>',$value);
	$array_id[]=$data[0];
	$array_name[]=$data[1];
	$array_comment[]=$data[2];
	$array_time[]=$data[3];
}


?>


<!DOCTYPE html>
<html>
<head>
<title>mission2-5</title>
</head>
<body>
<div>
 	<h1>入力フォーム</h1>
 	<form method="POST">
 		 名前：<br />
		<input type="hidden" name="completeEditId" value="<?php echo $default["id"] ?>"><br />
 		 <input type="text" name="name" required value="<?php echo $default["name"] ?>"><br />
  		コメント：<br />
 		 <textarea name="comment" cols="30" rows="5" required><?php echo $default["comment"]?></textarea><br />
  		<input type="submit" value="登録する" />
	</form>
</div>


<div class="show comments">
	<h1>投稿内容</h1>
	<?php for($i=0;$i<count($dataLine);$i++):?>
		<p>
			<?php echo $array_time[$i];?><br>
			ID:<?php echo $array_id[$i];?><br>
			NAME:<?php echo $array_name[$i];?><br>
			COMMENT:<br><?php echo $array_comment[$i];?>
		</p>
	<?php endfor?>
</div>

<div>
 	<h1>削除番号指定フォーム</h1>
	<form method="POST" > 
   		削除指定番号：<br />
		<input type="number" name="delete"><br /><br />
		<input type="submit" value="削除"> 
		</form> 
</div>
<div>
	<h1>編集番号指定フォーム</h1>
	<form method="POST">
	 	編集指定番号:<br/>
 		<input type="number" name="edit"><br /><br />
 		<input type="submit" value="編集">
		 </form>
</div>
	
</body>
</html>