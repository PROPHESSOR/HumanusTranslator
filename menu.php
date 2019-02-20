<?php
@ob_start();
require_once "inc/include.php";
require_once 'inc/loggedin_only.php';
require_once 'template/user_header.php';

?>
<title>Меню перевода</title>
<style>
.menubtn {
    display: block;
    float: left;
    background: black;
    width: 35vw;
    /* height: 100vh; */
    font-size: 2vw;
    border-radius:7px;
    padding: 25vh 0;
    text-align: center;
    color: white;
    text-decoration: none;
    font-weight: bolder;
}

.menubtn:hover {
    filter: brightness(2);
}

.background_paper {
    margin: auto;
    padding-top: 15vh;
    width: 75vw;
}
</style>
<div class="background_paper">
    <a class="menubtn" href="translate.php" style="background: #050;">Перевод</a>
    <a class="menubtn" href="check.php" style="background: #550;">Проверка</a>
</div>