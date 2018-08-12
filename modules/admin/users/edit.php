<?php
Core::$META['title'] = 'Редагування користувача';
$active = eNumArray('users', 'active');
$access = eNumArray('users', 'access');
$access_chat = eNumArray('users', 'access_chat');

$users = q("
    SELECT * FROM `users` 
    WHERE `id` = ".(int)($_GET['key2'])."
    LIMIT 1
");

if (!$users->num_rows) {
    $_SESSION['info'] = 'Цього користувача не існує!';
    header("Location: /admin/users");
    exit();
}
$row = $users->fetch_assoc();

if (isset($_POST['login'], $_POST['pass'], $_POST['name'], $_POST['email'], $_POST['age'], $_POST['active'], $_POST['access'], $_POST['remote_addr'], $_POST['http_user_agent'])) {
    
    $errors = array();
    
    if (mb_strlen($_POST['login']) < 2) {
        $errors['login'] = 'Логін занадто короткий';
    } elseif (mb_strlen($_POST['login']) > 16) {
        $errors['login'] = 'Логін занадто довгий';
    }
    
    
    if (mb_strlen($_POST['pass']) < 6) {
        $errors['pass'] = 'Пароль занадто короткий';
    } elseif (mb_strlen($_POST['pass']) > 16) {
        $errors['pass'] = 'Пароль занадто довгий';
    }
    
    if (mb_strlen($_POST['name']) < 2) {
        $errors['name'] = '"Ім\'я" занадто коротке';
    } elseif (mb_strlen($_POST['name']) > 16) {
        $errors['name'] = '"Ім\'я" занадто довге';
    }

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Треба коректно заповнити поле "E-mail"';
    }

    if ((int)($_POST['age']) < 12) {
        $errors['age'] = 'Малюкам тут буде не цікаво!';
    } elseif ((int)($_POST['age']) > 70) {
        $errors['age'] = 'У такому віці Вам тут буде не цікаво!';
    }
    
    if (!count($errors)) {
        
        $res = q("
            SELECT `id`
            FROM `users`
            WHERE `login` = '".es($_POST['login'])."'
            LIMIT 1
        ");
        $inspect = $res->fetch_assoc();
        if($res->num_rows && (int)($inspect['id']) != (int)($_GET['key2'])) {
            $errors['login'] = 'Такий логін вже зайнятий';
        }
        $res->close();
        
        $res = q("
            SELECT `id`
            FROM `users`
            WHERE `email` = '".es($_POST['email'])."'
            LIMIT 1
        ");
        $inspect = $res->fetch_assoc();
        if ($res->num_rows && (int)($inspect['id']) != (int)($_GET['key2'])) {
            $errors['email'] = 'Такий email вже зайнятий';
        }
        $res->close();
    }

    if (!count($errors)) {
        
        if($_POST['pass'] === $row['password']) {
            $password = $row['password'];
        } else {
            $password = myHash($_POST['pass']);
        }
        
        q("
            UPDATE `users` SET
            `login`           = '".es($_POST['login'])."',
            `password`        = '".es($password)."',
            `name`            = '".es($_POST['name'])."',
            `email`           = '".es($_POST['email'])."',
            `age`             = '".(int)($_POST['age'])."',
            `hash`            = '".es(myHash($_POST['login'].$_POST['email']))."',
            `active`          = '".es($_POST['active'])."',
            `access`          = '".es($_POST['access'])."',
            `remote_addr`     = '".es($_POST['remote_addr'])."',
            `http_user_agent` = '".es($_POST['http_user_agent'])."',
            `access_chat`     = '".es($_POST['access_chat'])."'
            WHERE `id`        = ".(int)($_GET['key2'])."
            ");
        $_SESSION['info'] = 'Запис був успішно відредагований!';
        header("Location: /admin/users");
        exit();
    }
}

if (isset($_POST['login'], $_POST['name'], $_POST['email'], $_POST['age'], $_POST['active'], $_POST['access'], $_POST['remote_addr'], $_POST['http_user_agent'], $_POST['access_chat'])) {
    foreach ($row as $key => $value) {
        if($key !== 'id' && $key !== 'hash' && $key !== 'password') {
            $row[$key] = $_POST[$key];
        }
    }
}