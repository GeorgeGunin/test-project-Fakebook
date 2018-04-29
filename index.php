
<?php
include_once 'app/helper.php';
my_session_start('fakebook');
$titles = 'Home page'; 
?>

<?php include 'templates/header.php'; ?>
<main>
  <h1>Welcome to Fake Book</h1>
  <p>
    On this site you can communicate with other members of this site.
  </p>
</main>
<?php include 'templates/footer.php'; ?> 