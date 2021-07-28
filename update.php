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
  if ($_POST['name'] ==='') {
    $error['name'] = 'blank';
  }
  if ($_POST['email'] === '') {
    $error['email'] = 'blank';
  }
  if (strlen($_POST['password']) < 4) {
    $error['password'] = 'length';
  }
  if ($_POST['password'] === '') {
    $error['password'] = 'blank';
  }

  if (empty($error)) {
    $user = $db->prepare('SELECT COUNT(*) AS cnt FROM users WHERE email=?');
    $user->execute(array($_POST['email']));
    $record = $user->fetch();
    if ($record['cnt'] > 0) {
      $error['email'] = 'duplicate';
    }
  }

  if (empty($error)) {
    $_SESSION['join'] = $_POST;
    header('Location: update_do.php');
    exit();
  }
}

if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
  $id = $_REQUEST['id'];

  $users = $db->prepare('SELECT * FROM users WHERE id=?');
  $users->execute(array($id));
  $user = $users->fetch();
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
  <div class="main" id="content">
    <h1>Simple BBS</h1>
    <hr>
    <hr>
    <div class="content">
    <h2>ユーザー編集画面</h2>
    <form action="" method="post">
      <input type="hidden" name="id" value="<?php print($id); ?>">
      <dl>
        <div class="content_name">
        <dt>名前</dt>
          <dd>
            <input type="text" name="name" value="<?php print($user['name']); ?>">
            <?php if ($error['name'] === 'blank'): ?>
              <p>* 名前を入力して下さい</p>
            <?php endif; ?>
          </dd>
        </div>

        <div class="content_email">
        <dt>メールアドレス</dt>
          <dd>
            <input type="email" name="email" value="<?php print($user['email']); ?>">
            <?php if ($error['email'] === 'blank'): ?>
              <p>* メールアドレスを入力して下さい</p>
            <?php endif; ?>
            <?php if ($error['email'] === 'duplicate'): ?>
              <p>* 指定されたメールアドレスは、既に登録されています</p>
            <?php endif; ?>
          </dd>
        </div>

        <div class="content_pass">
        <dt>新しいパスワード</dt>
          <dd>
            <input type="password" name="password" value="">
            <?php if ($error['password'] === 'length'): ?>
              <p>* パスワードは4文字以上で入力して下さい</p>
            <?php endif; ?>
            <?php if ($error['password'] === 'blank'): ?>
              <p>* パスワードを入力して下さい</p>
            <?php endif; ?>
          </dd>
        </div>
      </dl>
      <input type="submit" value="入力内容を確認する">
      |
      <a href="room.php">戻る</a>
    </form>
    </div>
  </div>
</div>
</body>
</html>