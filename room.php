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
    <p><a href="#">ユーザー名</a></p>
    <p><a href="input.html">新規投稿</a></p>
    <p><a href="#">ログアウト</a></p>
  </div>
  <div class="main">
    <h1>Simple BBS</h1>
      <?php
      require('dbconnect.php');

      $posts = $db->prepare('SELECT * FROM posts ORDER BY id DESC');
      $posts->bindParam(1, $start, PDO::PARAM_INT);
      $posts->execute();
      ?>
    <article>
      <?php while ($post = $posts->fetch()): ?>
        <p><a href="#"><?php print(mb_substr($post['message'], 0, 50)); ?></a></p>
        <time><?php print($post['created_at']); ?></time>
        <hr>
      <?php endwhile; ?>
    </article>
  </div>
</div>
</body>
</html>