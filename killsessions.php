<?php
@ob_start();
$sessionfolder = session_save_path();
unlink($sessionfolder);

?>

<meta charset="utf-8"/>

<h1>Все сессии в папке <?=$sessionfolder?> были убиты</h1>