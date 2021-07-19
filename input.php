<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();

  $users = $db->prepare('SELECT * FROM users WHERE id=?');
  $users->execute(array($_SESSION['id']));
  $user = $users->fetch();
} else {
  header('Location: login.php');
  exit();
}

if (!empty($_POST)) {
  if ($_POST['message'] !== '') {
    $message = $db->prepare('INSERT INTO posts SET user_id=?, message=?, created_at=NOW()');
    $message->execute(array(
      $user['id'],
      $_POST['message']
    ));

    header('Location: room.php');
    exit();
  }
}
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
    <h4>新規投稿画面</h4>
    <p><?php print(htmlspecialchars($user['name'], ENT_QUOTES)); ?>さん</p>
  </div>
  <div class="main">
    <h1>Simple BBS</h1>
    <form action="" method="post">
      <textarea name='message' cols="50" rows="10" placeholder="メッセージを記載して下さい"></textarea><br>
      <a href="room.php">戻る</a>
      |
      <button type="submit">投稿する</button>
    </form>
  </div>
</div>
</body>
</html>