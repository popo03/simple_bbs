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

        $statement = $db->prepare('INSERT INTO posts SET message=?, created_at=NOW()');
        $statement->bindParam(1, $_POST['message']);
        $statement->execute();
        echo 'メッセージが登録されました';

      ?>
      <pre>
        <a href="room.php">トップページに戻る</a>
      </pre>
  </div>
</div>
</body>
</html>