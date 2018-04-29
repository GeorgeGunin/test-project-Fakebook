<?php
require_once 'app/helper.php';
my_session_start('fakebook');
if (isset($_SESSION['user_id'])) {
  header('location:blog.php');
  exit;
}
$titles = 'Sign up';
$error = array("name" => '', "email" => '', "password" => '');


if (isset($_POST['submit']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['token']) {

  $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
  mysqli_query($link, 'SET NAMES utf8');

  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  $name = trim($name);

  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  $email = trim($email);

  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  $password = trim($password);

  $cpassword = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);
  $cpassword = trim($cpassword);

  $name = mysqli_real_escape_string($link, $name);
  $email = mysqli_real_escape_string($link, $email);
  $password = mysqli_real_escape_string($link, $password);
  $cpassword = mysqli_real_escape_string($link, $cpassword);

  $pass = true;

  if (!$name || mb_strlen($name) < 2 || mb_strlen($name) > 70) {
    $error["name"] = '*Name is required and must be (2 - 70) chars';
    $pass = false;
  }

  if (!$email) {
    $error["email"] = '*Email is required';
    $pass = false;
  } elseif (email_exist($link, $email)) {

    $error["email"] = '*This email is used ';
    $pass = false;
  }
  
  if (!$password || strlen($password) < 6) {
    $error["password"] = '*Password is required and must be min 6 charachters';
    $pass = false;
  } elseif ($password != $cpassword) {
    $error["password"] = '*Passwords do not match';
    $pass = false;
  }

  if ($pass) {
    $password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users VALUES ('','$name','$email','$password') ";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_affected_rows($link) == 1) {
      $_SESSION['user_id'] = mysqli_insert_id($link);
      $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
      $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
      $_SESSION['user_name'] = $name;
      header("location:blog.php?send_m=2");
      exit;
    }
  }
  $tken = my_token();
} else {
  $tken = my_token();
}
?>


<?php include 'templates/header.php'; ?>
<main>
  <h1>You can sign up here ..</h1>

  <form method="POST" novalidate="novalidate" action="">
    <label for="name">Name:</label><br>
    <input type="text" name="name" id="name" value="<?= old('name') ?>"><br>
    <span class="error"><?= $error['name'] ?></span><br>

    <label for="email">Email:</label><br>
    <input type="email" name="email" id="email" value="<?= old('email') ?>"><br>
    <span class="error"><?= $error['email'] ?></span><br>

    <input type="hidden" name='token' value='<?= $tken ?>'>

    <label for="password">Password:</label><br>
    <input type="password" name="password" id="password"><br>
    <span class="error"><?= $error['password'] ?></span><br>

    <label for="confirm-password">Confirm password:</label><br>
    <input type="password" name="confirm_password" id="confirm-password"><br><br>


    <input type="submit" name="submit" value="sign up">

  </form>
</main>
<?php include 'templates/footer.php'; ?> 

