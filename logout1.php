<?php
session_start();

?>

<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>logout</title>
　<link rel="stylesheet" href="center.css">
  </head>
  <body>
<span style="background-color:pink"><a href="top.php">トップ画面へ</a></span>
<span style="background-color:pink"><a href="mission_3-9.php">新規登録画面へ</a></span>
<span style="background-color:pink"><a href="mission_3-7.php">ログイン画面へ</a></span>
<span style="background-color:pink"><a href="main.php">メイン画面へ</a></span>
<span style="background-color:pink"><a href="logout1.php">ログアウト画面へ</a></span>

 <h1><font face="メイリオ" color="black">ログアウト</font></h1>
<p><?php echo $_SESSION['name'];?>さんの情報はまだ残っています</p>
  <ul>
  <li><a href="logout.php">ログアウトする</a></li>
  </ul>
  </body>
</html>
