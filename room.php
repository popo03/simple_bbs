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
    <p><a href="#"><?php print(htmlspecialchars($user['name'], ENT_QUOTES)); ?>さん</a></p>
    <p><a href="input.php">新規投稿</a></p>
    <p><a href="#">ログアウト</a></p>
  </div>
  <div class="main">
    <h1>Simple BBS</h1>
      <?php
      require('dbconnect.php');

      $posts = $db->query('SELECT u.name, p.* FROM users u, posts p WHERE u.id=p.user_id ORDER BY p.created_at DESC');
      ?>
    <article>
      <?php while ($post = $posts->fetch()): ?>
        <p><a href="#"><?php print(mb_substr($post['message'], 0, 50)); ?></a></p>
        <p>投稿者：<?php print($post['name']); ?>さん</p>
        <time><?php print($post['created_at']); ?></time>
        <hr>
      <?php endwhile; ?>
    </article>
  </div>
</div>
</body>
</html>