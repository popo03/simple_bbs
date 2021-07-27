<?php
session_start();
require('dbconnect.php');


$statement = $db->prepare('UPDATE users SET name=?, email=?, password=? WHERE id=?');
$statement->execute(array(
  $_SESSION['join']['name'],
  $_SESSION['join']['email'],
  sha1($_SESSION['join']['password']),
  $_SESSION['join']['id']
  ));
  unset($_SESSION['join']);

?>
<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<title>simple_bbs</title>
</head>

<body> 
<div class="wrapper">
  <div class="side_bar">
  </div>
  <div class="main">
    <h1>Simple BBS</h1>
      <pre>
        <p>ユーザー情報を変更しました</p>
        <a href="room.php">トップページに戻る</a>
      </pre>
  </div>
</div>
</body>
</html>