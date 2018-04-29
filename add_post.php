<?php
include_once 'app/helper.php';
my_session_start('fakebook');
if (!isset($_SESSION['user_id'])) {
  header('location:signin.php');
  exit;
}
$titles = 'Add posts' ;

$error = '';

if (isset($_POST['submit'])) {
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
  $title = trim($title);
  $article = filter_input(INPUT_POST, 'article', FILTER_SANITIZE_STRING);
  $article = trim($article);

  if (!$title) {
    $error = '*Title is required';
  } elseif (!$article) {
    $error = '*Article is required';
  } else {
    if (isset($_SESSION['user_id'])) {
      $uid = $_SESSION['user_id'];
      $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
      mysqli_query($link, 'SET NAMES utf8');

      $title = mysqli_real_escape_string($link, $title);
      $article = mysqli_real_escape_string($link, $article);

      $sql = "INSERT INTO posts values('','$uid','$title','$article',NOW()) ";

      $result = mysqli_query($link, $sql);

      if ($result && mysqli_affected_rows($link) == 1) {
        header('location:blog.php?send_m=3');
        exit;
      }
    }
  }
}
?>
<?php include 'templates/header.php'; ?>
<main>
  <h1>Add your post..</h1>
  <form method="POST" action="">
    <label for="title">Title:</label><br>
    <input typ="text" size="53" id="title" name="title" value="<?= old('title') ?>"><br>
    <label for="article">Article:</label><br>
    <textarea id="article" name="article"  cols="55.5"><?= old('article') ?></textarea><br>
    <input type ="button" value="cancel" onclick="window.location = 'blog.php'">
    <input type="submit" name="submit" value="post"> 
    <span class="error"><?= $error ?></span>
  </form>
</main>
<?php include 'templates/footer.php'; ?> 

