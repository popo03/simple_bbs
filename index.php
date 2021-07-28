<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/sanitize.css">
<link rel="stylesheet" href="css/style.css">
<title>simple_bbs</title>
</head>

<body> 
<div class="wrapper">
  <div class="side_bar">
    <div class="category">
      <p><a href="login.php">ログイン</a></p>
      <p><a href="create.php">新規ユーザー登録</a></p>
    </div>
  </div>
  <div class="main">
    <h1>Simple BBS</h1>
    <hr>
    <hr>
      <?php
      require('dbconnect.php');

      if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
      } else {
        $page = 1;
      }
      $start = 5 * ($page - 1);

      $posts = $db->prepare('SELECT * FROM posts ORDER BY id DESC LIMIT ?, 5');
      $posts->bindParam(1, $start, PDO::PARAM_INT);
      $posts->execute();
      ?>
    <article>
      <div class="show">
      <?php while ($post = $posts->fetch()): ?>
        <p><a href="login.php"><?php print(mb_substr($post['message'], 0, 50)); ?></a></p>
        <time><?php print($post['created_at']); ?></time>
        <hr>
      <?php endwhile; ?>
      </div>
      
      <?php if ($page >= 2): ?>
        <a href="index.php?page=<?php print($page-1); ?>"><?php print($page-1); ?>ページへ</a>
      <?php endif; ?>
      |
      <?php
        $counts = $db->query('SELECT COUNT(*) as cnt FROM posts');
        $count =$counts->fetch();
        $max_page = ceil($count['cnt'] / 5);
        if ($page < $max_page):
      ?>
        <a href="index.php?page=<?php print($page+1); ?>"><?php print($page+1); ?>ページへ</a>
      <?php endif; ?>
    </article>
  </div>
</div>
</body>
</html>