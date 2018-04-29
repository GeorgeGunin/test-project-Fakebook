<?php
include_once 'app/helper.php';
my_session_start('fakebook');
if (!valid_user()) {
  header('location:signin.php');
  exit;
}
$titles = 'Delete post';

if (isset($_POST['submit'])) {
  $pid = filter_input(INPUT_GET, 'pid' ,FILTER_SANITIZE_STRING);
  $pid = trim($pid);
  $uid = $_SESSION['user_id'];
  if (is_numeric($pid)) {
    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
    $pid = mysqli_real_escape_string($link, $pid);
    $sql = "DELETE FROM posts WHERE  user_id = $uid AND id = $pid";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_affected_rows($link) == 1) {
      header('location:blog.php?send_m=5');
      exit;
    } else {
     header('location:blog.php');
      exit;
    }
  }
}
?>
<?php include 'templates/header.php'; ?>
<main>
  <h3>Are you sure to delete this post ?</h3>
  <form method="POST" action="">
    <input type ="button" value="cancel" onclick="window.location = 'blog.php'">
    <input type="submit" name="submit" value="Delete"> 

  </form>
</main>
<?php include 'templates/footer.php'; ?> 

