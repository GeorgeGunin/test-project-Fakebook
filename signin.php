<?php
require_once 'app/helper.php';
my_session_start('fakebook');
if(isset($_SESSION['user_id'])){
  header('location:blog.php');
  exit;
}
$titles = 'Sign in' ;
$error = '';


if (isset($_POST['submit'])&& isset($_SESSION['token']) && $_SESSION['token'] == $_POST['token']) {


  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  $email = trim($email);

  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  $password = trim($password);

  if (!$email) {
    $error = '*Email is required';
  } 
  elseif (!$password) {
    $error = '*Password is required';
  }
  
  else{
  $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
  mysqli_query($link, 'SET NAMES utf8');

  $email = mysqli_real_escape_string($link, $email);
  $password = mysqli_real_escape_string($link, $password);

  $sql = "SELECT * FROM users WHERE email = '$email' limit 1";
  $result = mysqli_query($link, $sql);
  
  if ($result && mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
    
    if ($password == password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
      $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
      $_SESSION['user_name'] = $user['name'];
      if (valid_user()) {
        header('location:blog.php?send_m=1');
        exit;
      } 
    } else {
      $error = '*Wrong email and password combination';
    }
    
  }
  else {
      $error = '*Wrong email and password combination';
  }
} 
  $tken = my_token();
}
else{
  $tken = my_token();
}
?>


<?php include 'templates/header.php'; ?>
<main>
  <h1>You can sign in here ..</h1>
  <form method="POST" novalidate="novalidate" action="">
    <label for="email">Email:</label><br>
    <input type="email" name="email" id="email" value="<?= old('email') ?>"><br>
    <input type="hidden" name='token' value='<?= $tken ?>'>
    <label for="password">Password:</label><br>
    <input type="password" name="password" id="password"><br><br>
    <input type="submit" name="submit" value="sign in">
    <span class="error"><?= $error ?></span>
  </form>
</main>
<?php include 'templates/footer.php'; ?> 

