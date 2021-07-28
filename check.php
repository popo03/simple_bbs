<?php
session_start();
require('dbconnect.php');

if (!isset($_SESSION['join'])) {
  header('Location: index.php');
  exit();
}

if (!empty($_POST)) {
  $statement = $db->prepare('INSERT INTO users SET name=?, email=?, password=?, created_at=NOW()');
  $statement->execute(array(
    $_SESSION['join']['name'],
    $_SESSION['join']['email'],
    sha1($_SESSION['join']['password'])
  ));
  unset($_SESSION['join']);

  header('Location: thanks.php');
  exit();
}
?>
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
</div>

<div class="main">
  <h1>Simple BBS</h1>
  <hr>
  <hr>

  <div class="content">
    <h2>新規ユーザー登録画面</h2>
    <form action="" method="post">
      <input type="hidden" name="action" value="submit">
      <dl>

        <dt>名前</dt>
          <dd>
            <?php print(htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES)); ?>
          </dd>
          <hr>

        <dt>メールアドレス</dt>
          <dd>
            <?php print(htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES)); ?>
          </dd>
          <hr>

        <dt>パスワード</dt>
          <dd>
            【表示されません】
          </dd>
          <hr>
      </dl>
        <a href="create.php?action=rewrite">書き直す</a> | <input type="submit" value="登録する">
    </form>
  </div>
</div>
</body>
</html>