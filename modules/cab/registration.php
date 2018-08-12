<?php

if(isset($_POST['login'], $_POST['pass'], $_POST['name'], $_POST['email'], $_POST['age'])) {
    $errors = array();
    if(empty($_POST['login'])) {
        $errors['login'] = 'Треба заповнити поле "Логін"';
    } elseif (mb_strlen($_POST['login']) < 2) {
        $errors['login'] = '"Логін" занадто короткий';
    } elseif (mb_strlen($_POST['login']) > 16) {
        $errors['login'] = '"Логін" занадто довгий';
    }
    if(mb_strlen($_POST['pass']) < 6) {
        $errors['pass'] = '"Пароль" занадто короткий';
    } elseif(mb_strlen($_POST['pass']) > 16) {
        $errors['pass'] = '"Пароль" занадто довгий';
    }
    if(empty($_POST['name'])) {
        $errors['name'] = 'Треба вказати як Вас звать';
    } elseif (mb_strlen($_POST['name']) < 2) {
        $errors['name'] = '"Ім\'я" занадто коротке';
    } elseif (mb_strlen($_POST['name']) > 16) {
        $errors['name'] = '"Ім\'я" занадто довге';
    }
    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))  {
        $errors['email'] = 'Треба коректно заповнити поле "E-mail"';
    }
    if(empty($_POST['age'])) {
        $errors['age'] = 'Треба вказати скільки Вам років';
    } elseif ((int)($_POST['age']) < 12) {
        $errors['age'] = 'Малюкам тут буде не цікаво!';
    } elseif ((int)($_POST['age']) > 70) {
        $errors['age'] = 'У такому віці Вам тут буде не цікаво!';
    }

    if(!count($errors)) {
        $res = q("
            SELECT `id`
            FROM `users`
            WHERE `login` = '".es($_POST['login'])."'
            LIMIT 1
        ");
        if(mysqli_num_rows($res)) {
            $errors['login'] = 'Такий логін вже зайнятий';
        }
        $res = q("
            SELECT `id`
            FROM `users`
            WHERE `email` = '".es($_POST['email'])."'
            LIMIT 1
        ");
        if(mysqli_num_rows($res)) {
            $errors['email'] = 'Такий email вже зайнятий';
        }
    }
    
    if(!count($errors)) {
        q("
            INSERT INTO `users` SET
            `login`           = '".es($_POST['login'])."',
            `password`        = '".es(myHash($_POST['pass']))."',
            `name`            = '".es($_POST['name'])."',
            `email`           = '".es($_POST['email'])."',
            `age`             = ".(int)$_POST['age'].",
            `hash`            = '".es(myHash($_POST['login'].$_POST['email']))."',
            `remote_addr`     = '".es($_SERVER['REMOTE_ADDR'])."',
            `http_user_agent` = '".es($_SERVER['HTTP_USER_AGENT'])."'
        ");
        $id = mysqli_insert_id($link);

        $_SESSION['regok'] = 'Ok';

        Mail::$to = $_POST['email'];
        Mail::$subject = 'Реєстрація на сайті '.Core::$DOMAIN;
        Mail::$text = 'Шановний, '.$_POST['name'].'. Ви зареєструвалися на сайті '.Core::$DOMAIN.
                '<br>Перейдіть за посиланням для активації вашого акаунту:<br><a href="'.
                Core::$DOMAIN.'cab/activate/'.$id.'&hash='.
                myHash($_POST['login'].$_POST['email']).'">Активація</a>';
        Mail::send();
        header("Location: /cab/registration");
        exit();
    }
}

