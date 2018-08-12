<?php

if(isset($_POST['login'], $_POST['pass'], $_POST['email'])) {
    $errors = array();

    if (empty($_POST['login'])) {
        $errors['login'] = 'Ви не заповнили поле "Логін"';
    }
    if (empty($_POST['pass'])) {
        $errors['pass'] = 'Ви не заповнили поле "Пароль"';
    }
    if (empty($_POST['email'])) {
        $errors['email'] = 'Ви не заповнили поле "e-mail"';
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Ви не заповнили коректно поле "e-mail"';
    }

    if (!count($errors)) {
        setcookie("access", 1, time()+60, "/");
        $_COOKIE['access'] = 1;
     }
}

if (isset($_GET['key1']) && $_GET['key1'] == 'exit') {
    setcookie("access", 1, time()-60, "/");
    header("Location: /auth/auth");
    exit();
}