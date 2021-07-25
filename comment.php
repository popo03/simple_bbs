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
  if ($_POST['comment'] !== '') {
    $comment = $db->prepare('INSERT INTO talk_rooms SET user_id=?, message_id=?, comment=?, created_at=NOW()');
    $comment->execute(array(
      $user['id'],
      $_POST['message_id'],
      $_POST['comment']
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

      $posts = $db->prepare('SELECT u.name, p.* FROM users u, posts p WHERE u.id=p.user_id AND p.id=?');
      $posts->execute(array($id));
      $post = $posts->fetch();



      $messages = $db->prepare('SELECT u.name, t.* FROM users u, posts p, talk_rooms t WHERE u.id=t.user_id AND p.id=t.message_id ORDER BY t.created_at DESC');
      $messages->bindParam(1, $start, PDO::PARAM_INT);
      $messages->execute();
      ?>
    <article>
      <pre><?php print($post['message']); ?></pre>
      <p>投稿者：<?php print($post['name']); ?>さん, <?php print($post['created_at']); ?></p>
      <hr>
      <hr>
      <div style="width:100%; height:300px; overflow:auto">
        <?php while ($message = $messages->fetch()): ?>
         <?php if ($message['message_id'] === $_REQUEST['id']): ?>
          <p>
            <?php print($message['comment']); ?> ,
             投稿者：<?php print($message['name']); ?>さん, <?php print($message['created_at']); ?>
         </p>
         <hr>
         <?php endif; ?>
       <?php endwhile; ?>
      </div>

      <form action="" method="post">
        <textarea name='comment' cols="100" rows="5" placeholder="メッセージを記載して下さい"></textarea>
        <input type="hidden" name="message_id" value="<?php print(htmlspecialchars($_REQUEST['id'], ENT_QUOTES)); ?>">
        <p><button type="submit">送信</button>
        |
        <a href="room.php">戻る</a></p>
    </form>
    </article>
  </div>
</div>
</body>
</html>