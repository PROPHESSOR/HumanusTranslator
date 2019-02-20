<?php
@ob_start();
require_once 'inc/include.php';
require_once 'inc/loggedin_only.php';
require_once 'template/user_header.php';

$tmp = JSON::read('translation');

function getRandomString($tmp) {
    return false;
    $nottranslated      = [];
    $nottranslatedbyme  = [];

    for($i = 0; $i < count($tmp); $i++) {
        if(count($tmp[$i][2]) == 0) {
            $nottranslated[] = [$tmp[$i], $i];
        } else {
            $translatedbyme = false;

            for($j = 0; $j < count($tmp[$i][2]); $j++) {
                if($tmp[$i][2][$j][1] == $_SESSION['user']->user_user['login']) {
                    $translatedbyme = true;
                    break;
                }
            }

            if(!$translatedbyme) {
                $nottranslatedbyme[] = [$tmp[$i], $i];
            }
        }
    }

    if(count($nottranslated)) {
        $random = rand(0, count($nottranslated) - 1);
        return [$nottranslated[$random][0][1], $nottranslated[$random][1]];
    } else if(count($nottranslatedbyme)) {
        $random = rand(0, count($nottranslatedbyme) - 1);
        return [$nottranslatedbyme[$random][0][1], $nottranslatedbyme[$random][1]];
    } else {
        return false;
    }
}

$string = null; // [string, id]

if(isset($_SESSION['curstring']) && $_SESSION['curstring']) {
    $string = $_SESSION['curstring'];
} else if(empty($_POST)) {
    $string = getRandomString($tmp);
    $_SESSION['curstring'] = $string;
}

if(!empty($_POST)) {
    if(isset($_POST['skip'])) {
        $string = getRandomString($tmp);
        $_SESSION['curstring'] = $string;
    }
    if(isset($_POST['translation']) && $string) {
        $translated = htmlspecialchars(str_replace("\r\n", "\\n", $_POST['translation']));
        $tmp[$string[1]][2][] = [$translated, $_SESSION['user']->user_user['login'], 0, htmlspecialchars($_POST['comment'])];//TODO: Comment
        JSON::save('translation', $tmp);
        $_SESSION['user']->user_user['translated']++;
        $_SESSION['user']->save();
        //echo 'TRANSLATED: ' . $_POST['translation'] . '<br/>';
        $string = getRandomString($tmp);
        $_SESSION['curstring'] = $string;
    }
}

?>
<title>Перевод</title>
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

.bg {
    background: #022;
    padding: 5px;
}

textarea {
    margin: auto;
    background: #044;
    border: 1px solid green;
    padding: 5px;
    font-weight: bolder;
    color: white;
    font-family: monospace;
}

input[type="submit"] {
    width: 100%;
    padding: 1vmax;
}

.left {
    color: #333;
}
</style>
<?php

if($string) {
?>
<div class="background_paper">
    <div class="string" id="string"><?=str_replace("\\n", "<br/>", htmlspecialchars($string[0]))?></div>
    <form method="POST" onsubmit="return validate()" action="">
    <div class="bg"><center><textarea rows="5" cols="17" wrap="off" style="resize: none;" id="translation" autofocus name="translation"><?=str_replace("\\n", "&#13;&#10;", $string[0])?></textarea></center></div>
    <!-- <input type="text" id="translation" autofocus value="<?=$string[0]?>" name="translation"/> -->
    <input type="text" name="comment" placeholder="Комментарий (необязательно)"/><br/>
    <input type="submit" value="Отправить"><br/>
    </form>
    <form method="POST" action="">
    <input type="hidden" name="skip" value="1"/>
    <input type="submit" value="Пропустить"><br/>
    </form>
    <small class="left" id="left"></small>
    <span class="id"><?=$tmp[$string[1]][0]?></span>
</div>

<script>
    var origin       = document.querySelector('#string').innerText;
    var translation  = document.querySelector('#translation');
    var left         = document.querySelector('#left');
    //document.querySelector('#translation').addEventListener('keyup', function(event) {
      //  left.innerText = 'Осталось до оригинала: ' + (origin.length - translation.value.length);
    //})

    function validate() {
        if(translation.value === origin) {
            return Boolean(confirm('Вы действительно хотите отправить английский вариант текста как перевод?'));
        }
        
        var translationlines = translation.value.split('\n');
        for(var lineno in translationlines) {
            var line = translationlines[lineno];
            console.log(line, line.length);
            if(line.length > 18) {
                alert('Переполнение ' + (+lineno + 1) + ' строки! (' + line.length + ' символов)');
                return false;
            }
        }
        
        return true;
    }
</script>
<?php
} else {
?>
<div class="background_paper">
    <!-- <div class="string">Пока что, это всё ;) Вы можете гордиться собой!</div> -->
    <div class="string">Пока что, идёт проверка предыдущего перевода!</div>
</div>
<?php
}