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
    <p><a href="logout.php">ログアウト</a></p>
  </div>
  <div class="main">
    <h1>Simple BBS</h1>
      <?php
      require('dbconnect.php');

      if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
      } else {
        $page = 1;
      }
      $start = 5 * ($page - 1);

      $posts = $db->prepare('SELECT u.name, p.* FROM users u, posts p WHERE u.id=p.user_id ORDER BY p.created_at DESC LIMIT ?, 5');
      $posts->bindParam(1, $start, PDO::PARAM_INT);
      $posts->execute();
      ?>
    <article>
      <?php while ($post = $posts->fetch()): ?>
        <p><a href="comment.php?id=<?php print($post['id']); ?>"><?php print(mb_substr($post['message'], 0, 50)); ?></a></p>
        <p>
          投稿者：<?php print($post['name']); ?>さん , <?php print($post['created_at']); ?>
          <?php if ($_SESSION['id'] == $post['user_id']): ?>
          [<a href="delete.php?id=<?php print(htmlspecialchars($post['id'])); ?>">削除</a>]
          <?php endif; ?>
        </p>
        <hr>
      <?php endwhile; ?>

      <?php if ($page >= 2): ?>
        <a href="room.php?page=<?php print($page-1); ?>"><?php print($page-1); ?>ページ目へ</a>
      <?php endif; ?>
      |
      <?php
        $counts = $db->query('SELECT COUNT(*) as cnt FROM posts');
        $count = $counts->fetch();
        $max_page = ceil($count['cnt'] / 5);
        if ($page < $max_page):
      ?>
        <a href="room.php?page=<?php print($page+1); ?>"><?php print($page+1); ?>ページ目へ</a>
      <?php endif; ?>
    </article>
  </div>
</div>
</body>
</html>