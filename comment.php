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
      <?php
      require('dbconnect.php');

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
      <hr>


      <textarea name='message' cols="100" rows="5"></textarea>
    </article>
  </div>
</div>
</body>
</html>