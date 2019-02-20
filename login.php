<?php
@ob_start();
    require_once 'inc/include.php';
    require_once 'template/user_header.php';
?>
<title>Вход</title>

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
</style>

<?php

if(isset($_POST['login']) && isset($_POST['pass'])) {
    $login = /* htmlspecialchars( */$_POST['login']/* ) */;
    $pass  = /* md5( *//* htmlspecialchars( */$_POST['pass']/* )) */;

    $user = User::login($login, $pass);

    if($user) {
        // echo 'Есть такой';
        $user->addIP($_SERVER['REMOTE_ADDR']);
        $_SESSION['user_isloggedin'] = true;
        $_SESSION['user'] = $user;
        $user->save();
        header("Location: menu.php");
        die;
    } else {
        // echo 'Нет такого';
        ?>
        <div class="background_paper">
            Неверный логин/пароль<br/>
            <a href="login.php">Назад</a>
        </div>
        <?php
        die;
    }
}

if(!$_SESSION['user_isloggedin']) {
    ?>

    <div class="background_paper">
        <h1>Логин</h1>
        <form class="form" action="" method="POST">
            <label for="login">Логин:</label>
            <input type="text" name="login"><br/>
            <label for="pass">Пароль:</label>
            <input type="password" name="pass"><br/>
            <hr/>
            <input type="submit" value="Продолжить"><br/>
        </form>
    </div>
    <?php
} else {
    ?>
        <h1>Вы уже залогинились!</h1>
    <?php
    header("Location: menu.php");
    die;
}
// require_once 'footer.php';