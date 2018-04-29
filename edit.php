<?php
include_once 'app/helper.php';
my_session_start('fakebook');
if (!isset($_SESSION['user_id'])) {
  header('location:signin.php');
  exit;
}
$titles = 'Edit post';

$error = '';

$pid = filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_STRING);
$pid = trim($pid);


if (is_numeric($pid)) {
  $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
  mysqli_query($link, 'SET NAMES utf8');
  $pid = mysqli_real_escape_string($link, $pid);
  $uid = $_SESSION['user_id'];
  $sql = "SELECT *FROM posts WHERE user_id = $uid AND id = $pid ";
  $result = mysqli_query($link, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
    $s_row = mysqli_fetch_assoc($result);
  } else {
    header('location:blog.php');
    exit;
  }
} else {
  header('location:blog.php');
  exit;
}

if (isset($_POST['submit'])) {

  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $title = trim($title);
  $article = filter_input(INPUT_POST, 'article', FILTER_SANITIZE_STRING);
  $article = trim($article);

  if (!$title) {
    $error = '*Title is required';
  } elseif (!$article) {
    $error = '*Article is required';
  } else {
    if (isset($_SESSION['user_id'])) {

      $title = mysqli_real_escape_string($link, $title);
      $article = mysqli_real_escape_string($link, $article);

      $sql = "UPDATE posts SET title = '$title',article = '$article', date = NOW() WHERE user_id = $uid AND id = $pid ";

      $result = mysqli_query($link, $sql);

      if ($result) {
        header('location:blog.php?send_m=4');
        exit;
      }
    }
  }
}
?>
<?php include 'templates/header.php'; ?>
<main>
  <h1>Edit your post..</h1>
  <form method="POST" action="">
    <label for="title">Title:</label><br>
    <input typ="text" size="53" id="title" name="title" value="<?= htmlentities($s_row['title']) ?>"><br>
    <label for="article">Article:</label><br>
    <textarea id="article" name="article"  cols="55.5"><?= htmlentities($s_row['article']) ?></textarea><br>
    <input type ="button" value="cancel" onclick="window.location = 'blog.php'">
    <input type="submit" name="submit" value="Edit"> 
    <span class="error"><?= $error ?></span>
  </form>
</main>
<?php include 'templates/footer.php'; ?> 

