<?php
@ob_start();
require_once "inc/include.php";
require_once 'template/user_header.php';

$users = JSON::read('users');

for($i = 0; $i < count($users); $i++) {
    $users[$i]['rating'] = $users[$i]['translated'] + $users[$i]['checked'];
}

function cmp($a, $b) {
    if ($a['rating'] == $b['rating']) {
        return 0;
    }

    return ($a['rating'] > $b['rating']) ? -1 : 1;
}

usort($users, "cmp");

?>

<title>Рейтинг переводчиков</title>

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

    .rating_table {
        border-collapse: collapse;
        width: 100%;
    }

    .rating_table th, .rating_table td {
        border: 1px solid #555;
        padding: 5px;
    }
</style>

<div class="background_paper">
    <table class="rating_table">
    <tr>
        <th colspan="5">Рейтинг переводчиков</th>
    </tr>
    <tr>
        <th></th>
        <th>Ник</th>
        <th>Переведено</th>
        <th>Проверено</th>
        <th>Рейтинг</th>
    </tr>
<?php

foreach ($users as $key => $value) {
    ?>
        <tr>
            <td><?=$key + 1?></td>
            <td><?=$value['login']?></td>
            <td><?=$value['translated']?></td>
            <td><?=$value['checked']?></td>
            <td><?=$value['rating']?></td>
        </tr>
    <?php
}
?>
    </table>
</div>
