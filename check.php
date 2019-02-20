<?php
@ob_start();

//header("Location: menu.php");
//die;
require_once 'inc/include.php';
require_once 'inc/loggedin_only.php';
require_once 'template/user_header.php';

$tmp = JSON::read('translation');

function getRandomString($tmp) {
    return false;
    $notchecked      = [];
    $notcheckedbyme  = [];

    for($i = 0; $i < count($tmp); $i++) {
        if(count($tmp[$i][2]) == 0) continue;
        if(count($tmp[$i]) == 3 || count($tmp[$i][2]) < 2) continue;

        if(count($tmp[$i]) == 3 || count($tmp[$i][3]) == 0) {
            $notchecked[] = [$tmp[$i], $i];
        } else {
            $checkedbyme = false;

            for($j = 0; $j < count($tmp[$i][3]); $j++) {
                if($tmp[$i][3][$j] == $_SESSION['user']->user_user['login']) {
                    $checkedbyme = true;
                    break;
                }
            }

            if(!$checkedbyme) {
                $notcheckedbyme[] = [$tmp[$i], $i];
            }
        }
    }

    if(count($notchecked)) {
        $random = rand(0, count($notchecked) - 1);
        return [$notchecked[$random][0], $notchecked[$random][1]];
    } else if(count($notcheckedbyme)) {
        $random = rand(0, count($notcheckedbyme) - 1);
        return [$notcheckedbyme[$random][0], $notcheckedbyme[$random][1]];
    } else {
        return false;
    }
}

$string = null; // [string, id]

if(isset($_SESSION['curcheck']) && $_SESSION['curcheck']) {
    $string = $_SESSION['curcheck'];
} else if(empty($_POST)) {
    $string = getRandomString($tmp);
    $_SESSION['curcheck'] = $string;
}

if(!empty($_POST)) {
    if(isset($_POST['skip'])) {
        $string = getRandomString($tmp);
        $_SESSION['curcheck'] = $string;
    }
    if(isset($_POST['check']) && $string) {
        // print_r($_POST);
        foreach($_POST as $key => $value) {
            if($key == 'check') continue;

            $id = intval(substr($key, 1));

            if(count($tmp[$string[1]][2][$id]) == 2) $tmp[$string[1]][2][$id][] = 0;
            if($value == 'yes') $tmp[$string[1]][2][$id][2] = $tmp[$string[1]][2][$id][2] + 1;
            else if($value == 'no') $tmp[$string[1]][2][$id][2] = $tmp[$string[1]][2][$id][2] - 1;
            else echo 'Неверное значение radio кнопки... Угомонись, "хакер"!';
        }
        
        if(count($tmp[$string[1]]) == 3) $tmp[$string[1]][] = [];
        $tmp[$string[1]][3][] = $_SESSION['user']->user_user['login'];

        JSON::save('translation', $tmp);
        $_SESSION['user']->user_user['checked']++;
        $_SESSION['user']->save();

        $string = getRandomString($tmp);
        $_SESSION['curcheck'] = $string;
    }
}

?>
<title>Проверка</title>
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

input[type="submit"] {
    width: 100%;
    padding: 1vmax;
}

.check_table {
    width: 100%;
    border-collapse: collapse;
}

.check_table td,
.check_table th {
    border: 1px solid #555;
}

.check_radiotd {
    text-align: center;
}
</style>

<?php

if($string) {
?>
<div class="background_paper">
    <div class="string"><?=str_replace('\\n', '<br/>', $string[0][1])?></div>
    <form method="POST" onsubmit="return verify()" action="">
    <input type="hidden" name="check" value="1">
    <table class="check_table">
        <tr>
            <th width="75%">Перевод</th>
            <th width="25%">Комментарий</th>
            <th>Верный</th>
            <th>Неверный</th>
        </tr>
        <?php
            function cmp($a, $b) {
                if(count($a) == 2) $a[] = 0;
                if(count($b) == 2) $b[] = 0;

                if ($a[2] == $b[2]) {
                    return 0;
                }

                return ($a[2] > $b[2]) ? -1 : 1;
            }

            //usort($string[0][2], "cmp");
            for($i = 0; $i < count($string[0][2]); $i++) {
                $ttmp = $string[0][2][$i];
                ?>
                <tr class="check_row">
                    <td class="check_stringtd"><?=str_replace('\\n', '<br/>', $ttmp[0])?></td>
                    <td class="check_stringtd"><?=isset($ttmp[3]) ? ($ttmp[3]) : ""?></td>
                    <td class="check_radiotd"><input type="radio" name="r<?=$i?>" value="yes"/></td>
                    <td class="check_radiotd"><input type="radio" name="r<?=$i?>" value="no"/></td>
                </tr>
                <?php
            }
        ?>
    </table>
    <input type="submit" value="Отправить"><br/>
    </form>
    <form method="POST" action="">
    <input type="hidden" name="skip" value="1"/>
    <input type="submit" value="Пропустить"><br/>
    </form>
    <span class="id"><?=$tmp[$string[1]][0]?></span>
</div>
<?php
} else {
?>
<div class="background_paper">
    <div class="string">Пока что, это всё ;) Вы можете гордиться собой!</div>
    <!-- <div class="string">Пока что, идёт перевод... Проверка будет доступна позже ;)</div> -->
</div>
<?php
}
?>

<script>

function verify() {
    const rows = document.querySelectorAll('.check_row');

    for(const row of rows) {
        if(row.querySelectorAll('input:checked').length !== 1) {
            alert("Укажите правильность для всех переводов!");
            return false;
        }
    }
    
    return true;
}

</script>