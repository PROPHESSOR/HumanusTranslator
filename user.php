<?php
@ob_start();
require_once 'inc/include.php';
require_once 'template/user_header.php';

$sessionUser = $_SESSION['user'];
$sessionUserUser = $sessionUser->user_user;

?>
<title>Профиль</title>
<style>
.background_paper {
    margin: auto;
    padding: 1vmax;
    border-radius: 15px;
    /* padding-top: 15vh; */
    width: 25vw;
    background: white;
    position: relative;
    padding-bottom: 2vmax;
}

.string {
    padding: 15px;
    color: white;
    font-weight: bold;
    background: #040;
    border: 7px double #020;
}

.id {
    position: absolute;
    bottom: 10px;
    right: 15px;
}

form {
    margin: 0;
}

input[type="text"] {
    margin: 5px 0;
    width: 100%;
    height: 5vh;
    background: #044;
    border: 1px solid green;
    padding: 15px;
    font-weight: bolder;
    color: white;
}

th {
    text-align: left;
}

input[type="submit"] {
    width: 100%;
    padding: 1vmax;
}
</style>

<div class="background_paper">
    <table>
        <tr>
            <td>Логин:</td>
            <th><?=$_SESSION['user']->user_user['login']?></th>
        </tr>
        <tr>
            <td>Переведено строк:</td>
            <th><?=$_SESSION['user']->user_user['translated']?></th>
        </tr>
        <tr>
            <td>Проверено строк:</td>
            <th><?=$_SESSION['user']->user_user['checked']?></th>
        </tr>
        <tr>
            <td colspan="2"><a href="rating.php">Место в топе</a></td>
        </tr>
    </table>
</div>