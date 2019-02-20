<?php
require_once "inc/include.php";
?>

<style>
.user-header {
    color: white;
    background: rgba(64, 64, 64, .5);
    width: 100%;
}

.user-header a {
    display: block;
    color: white;
    text-decoration: none;
}

.user-header a:visited {
    color: white;
    background: rgba(255, 255, 255, .5);
}

.user-header th,
.user-header td {
    border: 0;
}

.user-header .brandlogo {
    font-weight: bolder;
}
</style>

<?php

if($_SESSION['user_isloggedin']) {
    ?>
        <table class="user-header">
            <tr>
                <td width="80%" class="brandlogo"><a href="menu.php">В меню перевода</a></td>
                <td><a href="user.php"><img src="<?=
                    $_SESSION['user']->user_user['isadmin']
                        ? 'img/admin_man_on.gif'
                        : 'img/man_on.gif'
                    ?>"/> <?=$_SESSION['user']->user_user['login']?></a></td>
                <td><a href="logout.php">Выйти</a></td>
            </tr>
        </table>
    <?php
} else {
    ?>
        <table class="user-header">
            <tr>
                <td width="80%" class="brandlogo"><a href="index.php">На главную</a></td>
                <td></td>
                <td><a href="register.php">Регистрация</a></td>
                <td><a href="login.php">Вход</a></td>
            </tr>
        </table>
    <?php
}