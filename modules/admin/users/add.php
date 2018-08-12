<?php
Core::$META['title'] = 'Додавання користувача';
if(isset($_SESSION['user'])) {
    $active = eNumArray('users', 'active');
    $access = eNumArray('users', 'access');
    $access_chat = eNumArray('users', 'access_chat');
    
    if (isset($_POST['login'], $_POST['pass'], $_POST['name'], $_POST['email'], $_POST['age'], $_POST['active'], $_POST['access'], $_POST['remote_addr'], $_POST['http_user_agent'], $_POST['access_chat'])) {
        
        $errors = array();
        
        if (mb_strlen($_POST['login']) < 2) {
            $errors['login'] = 'Логін занадто короткий';
        } elseif (mb_strlen($_POST['login']) > 16) {
            $errors['login'] = 'Логін занадто довгий';
        }
        
        if (mb_strlen($_POST['pass']) < 6) {
            $errors['pass'] = 'Пароль занадто короткий';
        } elseif(mb_strlen($_POST['pass']) > 16) {
            $errors['pass'] = 'Пароль занадто довгий';
        }
        
        if (mb_strlen($_POST['name']) < 2) {
            $errors['name'] = 'Ім\'я занадто коротке';
        } elseif (mb_strlen($_POST['name']) > 16) {
            $errors['name'] = 'Ім\'я занадто довге';
        }
        
        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Треба коректно заповнити поле "E-mail"';
        }
        
        if ((int)($_POST['age']) < 12) {
            $errors['age'] = 'Малюкам тут буде не цікаво!';
        } elseif ((int)($_POST['age']) > 70) {
            $errors['age'] = 'У такому віці Вам тут буде не цікаво!';
        }
        
        if (empty($_POST['active'])) {
            $errors['active'] = 'Не вказана активність користувача!';
        }
        
        if (empty($_POST['access'])) {
            $errors['access'] = 'Не вказаний рівень допуску користувача!';
        }
        
        if (empty($_POST['remote_addr']) || !filter_var($_POST['remote_addr'], FILTER_VALIDATE_IP)) {
            $errors['remote_addr'] = 'Не вказана IP-адреса!';
        }
        
        if (empty($_POST['http_user_agent'])) {
            $errors['http_user_agent'] = 'Не вказаний user-agent!';
        }

        if (empty($_POST['access_chat'])) {
            $errors['access_chat'] = 'Не вказана можливість писати у чат!';
        }
    
        if (!count($errors)) {
            
            $res = q("
                SELECT `id`
                FROM `users`
                WHERE `login` = '".es($_POST['login'])."'
                LIMIT 1
            ");
            if ($res->num_rows) {
                $errors['login'] = 'Такий логін вже зайнятий';
            }
            $res->close();

            $res = q("
                SELECT `id`
                FROM `users`
                WHERE `email` = '".es($_POST['email'])."'
                LIMIT 1
            ");
            if ($res->num_rows) {
                $errors['email'] = 'Такий email вже зайнятий';
            }
            $res->close();
        }
        
        if (!count($errors)) {
            q("
                INSERT INTO `users` SET
                `login`           = '".es($_POST['login'])."',
                `password`        = '".es(myHash($_POST['pass']))."',
                `name`            = '".es($_POST['name'])."',
                `email`           = '".es($_POST['email'])."',
                `age`             = '".es($_POST['age'])."',
                `hash`            = '".es(myHash($_POST['login'].$_POST['email']))."',
                `active`          = '".es($_POST['active'])."',
                `access`          = '".es($_POST['access'])."',
                `remote_addr`     = '".es($_POST['remote_addr'])."',
                `http_user_agent` = '".es($_POST['http_user_agent'])."',
                `access_chat`     = '".es($_POST['access_chat'])."'
            ");

            $_SESSION['info'] = 'Запис був успішно доданий!';
            header("Location: /admin/users");
            exit();
        }
    }
} else {
    header("Location: /cab/auth");
    exit();
}