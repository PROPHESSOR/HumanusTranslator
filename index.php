<?php
@ob_start();
require_once 'inc/include.php';
require_once "template/user_header.php";
?>

<meta charset="utf-8"/>
<title>Перевод DRRP</title>
<style>
.background_paper {
    margin: auto;
    padding: 1vmax;
    border-radius: 15px;
    /* padding-top: 15vh; */
    width: 38vw;
    background: white;
    position: relative;
    padding-bottom: 2vmax;
    font-size: 150%;
}

form {
    margin: 0;
}

input[type="text"],
input[type="password"] {
    margin: 5px 0;
    width: 100%;
    height: 5vh;
    /* background: #044; */
    border: 1px solid black;
    padding: 15px;
    font-weight: bolder;
    /* color: white; */
}

input[type="submit"] {
    width: 100%;
    padding: 1vmax;
}

.button {
    margin: 5px 0;
    display: block;
    padding: 1vmax;
    background: black;
    color: white;
    font-weight: bolder;
    /* width: 100%; */
    text-align: center;
    border-radius: 25px;
    text-decoration: none;
}

.button:hover {
    filter: brightness(1.5);
}
</style>
<?php

if($_SESSION['user_isloggedin']) {
    header("Location: menu.php");
    die;
}

?>
<div class="background_paper">
    На данном сайте вы можете принять участие в переводе<br/> <b>Doom RPG Remake Project</b> на русский язык!<br/>
    Оригинальный перевод Doom RPG от Бойко Тимофея<br/> содержит множество неточностей и странных выражений,<br/> 
    так что целью данного проекта является исправление этих косяков.
    <a class="button" href="register.php" style="background: green;">Начать</a>
    <a class="button" href="login.php" style="background: blue;">Продолжить</a>
</div>