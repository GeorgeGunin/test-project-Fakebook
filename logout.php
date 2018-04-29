<?php

include_once 'app/helper.php';
my_session_start('fakebook');
session_destroy();
header('location:signin.php');

