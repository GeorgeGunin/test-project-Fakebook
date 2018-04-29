<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>FAKE BOOK | <?= $titles?></title>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <div class="wrapper">
      <header>
        <nav>
          <ul>
            <li><a  href="./">FAKE BOOK</a></li>
            <li><a  href="about.php">About</a></li>
            <li><a  href="blog.php">Blog</a></li>
            <?php if(!isset($_SESSION['user_id'])):?>
            <li><a href="signin.php">Sign in</a></li>
            <li><a href="signup.php">Sign up</a></li>
            <?php else: ?>
            <li class="white" >Welcome back <?=$_SESSION['user_name'];?></li>
            <li><a href="logout.php">Log out</a></li>
            <?php endif;?>
          </ul>
        </nav>
      </header>
      <?php if(isset($_GET['send_m'])&& isset($ms[$_GET['send_m']])):?>
      <div class="ms-box">
        <p><?=$ms[$_GET['send_m']]?></p>
      </div>
      <?php endif;?>