<?php

if (isset($_SESSION['user']) && $_SERVER['REQUEST_URI'] != '/cab/auth') {
    $res = q("
        SELECT * 
        FROM `users`
        WHERE `id`  = ".(int)($_SESSION['user']['id'])."
        AND `login` = '".es($_SESSION['user']['login'])."'
        LIMIT 1
    ");
    
    $_SESSION['user'] = mysqli_fetch_assoc($res);
    
    if($_SESSION['user']['active'] != 'активний') {
        include './modules/cab/exit.php';
    }
} else {
    //Користувач може використовувати автоавторизацію. Перевірка даних кукі
    if(isset($_COOKIE['autoAuth'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'])) {
        $res = q("
            SELECT * 
            FROM `users`
            WHERE `login`         = '".es($_SESSION['user']['login'])."'
            AND `hash`            = '".es($_COOKIE['autoAuth'])."'
            AND `remote_addr`     = '".es($_SERVER['REMOTE_ADDR'])."'
            AND `http_user_agent` = '".es($_SERVER['HTTP_USER_AGENT'])."'
            AND `active`          = 'активний'
            LIMIT 1
        ");
        //Використовує та дані у куках співпадають
        if(mysqli_num_rows($res)) { 
            $_SESSION['user'] = mysqli_fetch_assoc($res);
        //Використовує, але дані в куках не співпадають -> на вихід
        } else {
            include './modules/cab/exit.php';
        }
        //Не використовує -> тоді треба авторизуватись
    } else {
        include './modules/cab/auth.php';
    }
}