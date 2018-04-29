<?php

define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PWD', '');
define('MYSQL_DB', 'fakebook');

$ms = [
    1 => 'Welcome back',
    2 => 'Congratulations you  signed in, enjoy !!!',
    3 => 'New Post is up',
    4 => 'Your post is updated',
    5 => 'Post is deleted'
];

if (!function_exists('old')) {

  function old($field) {

    return !empty($_POST[$field]) ? trim($_POST[$field]) : '';
  }

}

if (!function_exists('my_token')) {

  function my_token() {

    $token = sha1('$$$ fakebook' . rand(1, 100) . date('H.m.s'));
    $_SESSION['token'] = $token;
    return $token;
  }

}

if (!function_exists('valid_user')) {

  function valid_user() {

    $valid = false;

    if (isset($_SESSION['user_id'])) {

      if (isset($_SESSION['user_ip']) && $_SESSION['user_ip'] == $_SERVER['REMOTE_ADDR']) {

        if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] == $_SERVER['HTTP_USER_AGENT']) {
          
            $valid = true;
          
        }
      }
    }
    return $valid;
  }

}

if (!function_exists('my_session_start')) {

  function my_session_start($name = null) {
    session_set_cookie_params(60*60*24*7);
    if (!is_null($name)) {
      session_name($name);
    }

    session_start();
    session_regenerate_id();
  }

}

if(!function_exists('email_exist')){
  
  function email_exist($link,$email){
    $exist = false;
    $email = htmlentities($email);
    $sql = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $sql);
    if($result && mysqli_num_rows($result) > 0){
      $exist = true;
    }
    
    return $exist;
  }
  
}


