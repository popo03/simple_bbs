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
    <?php print(htmlspecialchars($user['name'], ENT_QUOTES)); ?>さん
  </div>
  <div class="main">
    <h1>Simple BBS</h1>
      <?php

      $id = $_REQUEST['id'];
      if (!is_numeric($id) || $id <= 0) {
        header('Location: room.php');
        exit();
      }

      $posts = $db->prepare('SELECT * FROM posts WHERE id=?');
      $posts->execute(array($id));
      $post = $posts->fetch();
      ?>
    <article>
      <pre><?php print($post['message']); ?></pre>
      <p>投稿者：<?php print($post['name']); ?>, <?php print($post['created_at']); ?></p>
      <hr>


      <textarea name='message' cols="100" rows="5"></textarea>
      <p><input type="submit" value="送信">
      |
      <a href="room.php">戻る</a></p>
    </article>
  </div>
</div>
</body>
</html>