<?php
session_start();
require('dbconnect.php');

if (!empty($_POST)) {
  if ($_POST['email'] === '') {
    $error['email'] = 'blank';
  }
  if ($_POST['password'] === '') {
    $error['password'] = 'blank';
  }

  if ($_POST['email'] !== '' && $_POST['password'] !== '') {
    $login = $db->prepare('SELECT * FROM users WHERE email=? AND password=?');
    $login->execute(array(
      $_POST['email'],
      sha1($_POST['password'])
    ));
    $user = $login->fetch();

    if ($user) {
      $_SESSION['id'] = $user['id'];
      $_SESSION['time'] = time();

      header('Location: room.php');
      exit();
    } else {
      $error['login'] = 'failed';
    }
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
    <p><a href="create.php">新規ユーザー登録</a></p>
  </div>
  <div class="main">
    <p><h2>ログイン画面</h2></p>
    <form action="" method="post">
      <dl>
        <dt>メールアドレス</dt>
        <dd>
          <input type="text" name="email" value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>">
          <?php if ($error['email'] === 'blank'): ?>
            <p>*メールアドレスを入力して下さい</p>
          <?php endif; ?>
        </dd>
        <dt>パスワード</dt>
        <dd>
          <input type="password" name="password" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>">
          <?php if ($error['password'] === 'blank'): ?>
            <p>*パスワードを入力して下さい</p>
          <?php endif; ?>
          <?php if ($error['login'] === 'failed'): ?>
            <p>*ログインに失敗しました。正しく入力して下さい</p>
          <?php endif; ?>
        </dd>
      </dl>
    <input type="submit" value="ログインする">
    <a href="index.php">トップページに戻る</a>
  </div>
</div>
</body>
</html>