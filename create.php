<?php
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
  
  if (empty($error)) {
    header('Location: check.php');
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

  </div>
  <div class="main" id="content">
    <p>新規ユーザー登録画面</p>
    <form action="" method="post">
      <dl>
       <dt>名前</dt>
         <dd>
            <input type="text" name="name" value="<?php print(htmlspecialchars($_POST['name'], ENT_QUOTES)); ?>">
            <?php if ($error['name'] === 'blank'): ?>
              <p>* 名前を入力して下さい</p>
            <?php endif; ?>
          </dd>
        <dt>メールアドレス</dt>
          <dd>
            <input type="email" name="email" value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>">
            <?php if ($error['email'] === 'blank'): ?>
              <p>* メールアドレスを入力して下さい</p>
            <?php endif ?>
          </dd>
        <dt>パスワード</dt>
          <dd>
            <input type="password" name="password" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>">
            <?php if ($error['password'] === 'length'): ?>
             <p>* パスワードは4文字以上で入力して下さい</p>
            <?php endif ?>
            <?php if ($error['password'] === 'blank'): ?>
              <p>* パスワードを入力して下さい</p>
            <?php endif ?>
          </dd>
      </dl>
      <input type="submit" value="入力内容を確認する">
      <a href="index.php">戻る</a>
    </form>
  </div>
</div>
</body>
</html>