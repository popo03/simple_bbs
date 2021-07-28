<?php
session_start();
require('dbconnect.php');

if (!empty($_POST)) {
  if ($_POST['name'] === '') {
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

  //アカウントの重複チェック
  if (empty($error)) {
    $member = $db->prepare('SELECT COUNT(*) AS cnt FROM users WHERE email=?');
    $member->execute(array($_POST['email']));
    $record = $member->fetch();
    if ($record['cnt'] > 0) {
      $error['email'] = 'duplicate';
    }
  }
  
  if (empty($error)) {
    $_SESSION['join'] = $_POST;
    header('Location: check.php');
    exit();
  }
}

if ($_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])) {
  $_POST = $_SESSION['join'];
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
    <div class="category">
      <p><a href="login.php">ログイン画面へ</a></p>
      <p><a href="index.php">トップページに戻る</a></p>
    </div>
  </div>
  <div class="main" id="content">
    <h1>Simple BBS</h1>
    <hr>
    <hr>
    <div class="content">
      <h2>新規ユーザー登録画面</h2>
      <form action="" method="post">
      <dl>
        <div class="content_name">
          <dt>名前</dt>
          <dd>
            <input type="text" name="name" value="<?php print(htmlspecialchars($_POST['name'], ENT_QUOTES)); ?>">
            <?php if ($error['name'] === 'blank'): ?>
              <p>* 名前を入力して下さい</p>
            <?php endif; ?>
          </dd>
        </div>

        <div class="content_email">
          <dt>メールアドレス</dt>
          <dd>
            <input type="email" name="email" value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>">
            <?php if ($error['email'] === 'blank'): ?>
              <p>* メールアドレスを入力して下さい</p>
            <?php endif; ?>
            <?php if ($error['email'] === 'duplicate'): ?>
              <p>* 指定されたメールアドレスは、既に登録されています</p>
            <?php endif; ?>
          </dd>
        </div>

        <div class="content_pass">
          <dt>パスワード</dt>
          <dd>
            <input type="password" name="password" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>">
            <?php if ($error['password'] === 'length'): ?>
             <p>* パスワードは4文字以上で入力して下さい</p>
            <?php endif; ?>
            <?php if ($error['password'] === 'blank'): ?>
              <p>* パスワードを入力して下さい</p>
            <?php endif; ?>
          </dd>
        </div>
      </dl>
      <div class="content_button">
        <input type="submit" value="入力内容を確認する">
      </div>
    </form>
    </div>
  </div>
</div>
</body>
</html>