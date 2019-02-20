<?php
require_once 'inc/include.php';

if(!($_SESSION['user_isloggedin'])) {
    header("Location: login.php");
    die;
}