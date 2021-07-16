<?php
require('dbconnect.php');

?>
<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<title>simple_bbs</title>
</head>

<body> 
<div id="content">
  <p>新規ユーザー登録画面</p>
  <form action="" method="post">
    <dl>
      <dt>名前</dt>
        <dd>
          <input type="text" name="name" value="">
        </dd>
      <dt>メールアドレス</dt>
        <dd>
          <input type="email" name="email" value="">
        </dd>
      <dt>パスワード</dt>
        <dd>
          <input type="password" name="password" value="">
        </dd>
    </dl>
    <input type="submit" value="入力内容を確認する">
    <a href="index.php">戻る</a>
  </form>
</div>
</body>
</html>