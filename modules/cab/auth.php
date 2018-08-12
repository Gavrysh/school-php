<?php

if (isset($_POST['login'], $_POST['pass'])) {
    $res = q("
        SELECT * 
        FROM `users`
        WHERE `login`  = '".es($_POST['login'])."'
        AND `password` = '".es(myHash($_POST['pass']))."'
        AND `active`   = 'активний'
        LIMIT 1
    ");

    if (mysqli_num_rows($res)) {
        $_SESSION['user'] = mysqli_fetch_assoc($res);
        $status = 'OK';
        if (isset($_POST['autoAuth'])) {
            setcookie("autoAuth", myHash($_SESSION['user']['id'].$_SESSION['user']['hash']), time()+60*60*24, "/");
            $_COOKIE['autoAuth'] = myHash($_SESSION['user']['id'].$_SESSION['user']['hash']);
            q("
                UPDATE `users` SET
                `hash`            = '".es($_COOKIE['autoAuth'])."',
                `remote_addr`     = '".es($_SERVER['REMOTE_ADDR'])."',
                `http_user_agent` = '".es($_SERVER['HTTP_USER_AGENT'])."'
                WHERE `id`        = ".(int)($_SESSION['user']['id'])."
                AND `active`      = 'активний'
              ");
        } else {
            setcookie("autoAuth", "", time()-3600, "/");
        }
    } else {
        $error = 'Користувача з таким логіном та паролем не існує!';
    }
} else {
    $status = 'error';
}