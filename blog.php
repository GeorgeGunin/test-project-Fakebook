<?php
include_once 'app/helper.php';
my_session_start('fakebook');

if (!isset($_SESSION['user_id'])) {
  header('location: signin.php');
  exit;
}
$titles = 'Blog';
$posts = [];

$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
mysqli_query($link, 'SET NAMES utf8');
$sql = "SELECT p.*,u.name FROM posts p JOIN "
        . " users u ON p.user_id = u.id "
        . " ORDER BY p.date DESC ";

$result = mysqli_query($link, $sql);

if ($result && mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {

    $posts[] = $row;
  }
}
?>

<?php include 'templates/header.php'; ?>
<main>
  <h1>You can blog here ..</h1>
  <input type="button" value = "+Add POST" onclick="window.location = 'add_post.php'"><br>

  <?php if ($posts): ?>
    <div class = "blogs">
      <?php foreach ($posts as $post): ?>
        <div class="blog-box">

          <h3><?= htmlentities($post['title']); ?></h3>

          <p><?= str_replace("\n", '<br>', htmlentities($post['article'])); ?></p>

          <p>Name: <?= htmlentities($post['name']); ?> | Date: <?= $post['date']; ?>
          <?php if($_SESSION['user_id'] == $post['user_id']):?>
           <span class = "delete-edit">
            <a href="edit.php?pid=<?=$post['id']?>">Edit</a> | 
            <a href="delete_post.php?pid=<?= $post['id']; ?>">Delete</a>
          
            </span>
          <?php endif;?>
          </p>
          
        </div>

      <?php endforeach; ?>

    </div>
  <?php endif; ?>

</main>
<?php include 'templates/footer.php'; ?> 

