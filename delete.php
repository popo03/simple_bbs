<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])) {
  $id = $_REQUEST['id'];

  $messages = $db->prepare('SELECT * FROM posts WHERE id=?');
  $messages->execute(array($id));
  $message = $messages->fetch();

  $posts = $db->prepare('SELECT * FROM talk_rooms WHERE message_id=?');
  $posts->execute(array($id));
  $post = $posts->fetch();

  if ($message['user_id'] == $_SESSION['id']) {
    $del = $db->prepare('DELETE FROM posts WHERE id=?');
    $del->execute(array($id));

    $dele = $db->prepare('DELETE FROM talk_rooms WHERE message_id=?');
    $dele->execute(array($id));
  }
}

header('Location: room.php');
exit();
?>