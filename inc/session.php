<?php

session_start();

if(!isset($_SESSION['user_isloggedin'])) {
    $_SESSION['user_isloggedin']    = false;
    $_SESSION['user']               = null;
    $_SESSION['curstring']          = null;
}

/* 

user_isloggedin
user_id
user_login
user_registered
user_translated
user_isadmin

*/