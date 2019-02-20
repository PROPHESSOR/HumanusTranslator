<?php
@ob_start();
?>
<title>Регистрация</title>
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
require_once 'inc/include.php';
require_once 'template/user_header.php';

if(/**/isset($_POST['login'])
    && isset($_POST['pass'])) {
    
    $login   = htmlspecialchars($_POST['login']);
    $pass    = md5($_POST['pass']);

    if(User::isLoginExist($login)) {
        ?>
            <div class="background_paper">
                Данный логин уже занят<br/>
                <a href="register.php">Назад</a>
            </div>
        <?php
        die;
    }

    $user = new User([
        'login'=>$login,
        'password'=>$pass,
        'registered'=>date('D M d Y H:i:s O'),
        'translated'=>0,
        'checked'=>0,
        'isadmin'=>false,
        'ips'=>[$_SERVER['REMOTE_ADDR']],
        'isnew'=>true,
        'id'=>count(JSON::read('users'))
    ]);

    $_SESSION['user'] = $user;
    $user->save();
        
    ?>
    <div class="background_paper">
        Вы были успешно зарегистрированы!<br/>
        <a href="login.php">Войти в систему сейчас</a>
    </div>
    <?php
    die;
}

?>

<div class="background_paper">
    <h1>Регистрация</h1>
    <form class="form" action="" method="POST">
        <label for="login">Логин:</label>
        <input type="text" required pattern="[A-Za-z0-9_]{4,}" name="login"/><br/>
        <label for="pass">Пароль:</label>
        <input type="password" required name="pass"/><br/>
        <hr/>
        <input type="submit" value="Начать"/>
    </form>
</div>
</body>
</html>
<?php
// require_once 'footer.php';