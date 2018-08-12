<?php
Core::$META['title'] = 'Перегляд профайлу користувача';
$errors = array();
//Папка для завантажених файлів
$uploaddir = '/uploaded/';
//Бажані розміри нового зображення у пікселях
$full_widht = 100;
$full_height = 100;
//Бажані розміри мініатюри, px
$mini_widht = 50;
$mini_height = 50;

$profile = q("
    SELECT * FROM `users`
    WHERE `login` = '".es($_SESSION['user']['login'])."'
    LIMIT 1
");

$row = mysqli_fetch_assoc($profile);
if(!$row['img']) {
    $row['img'] = 'default.png';
}

if(isset($_POST['uploadImage'])) {
    if(isset($_SESSION['img'])) {
        if (unlink(realpath('.'.$uploaddir.$_SESSION['img']))) {
            //все добре
        } else {
            //такого файлу не існує
        }
    }
    $r_upload = Images::uploadImg($_FILES['file']['name'], $_FILES['file']['tmp_name']);
        
    if($r_upload['new_name'] !== 'noname') {
        $_SESSION['info'] = 'Файл корректний та вдало завантажений.';
        $_SESSION['img'] = $r_upload['new_name'];
    } else {
        $_SESSION['info'] = 'Завантаження файлу пройшло з помилками!<br>'.$r_upload['error'];
        $_SESSION['img'] = 'default.png';
        $errors['upload'] = $_SESSION['info'];
    }    
}

if(isset($_POST['save'])) {
    if(isset($_SESSION['img']) && $_SESSION['img'] !== 'default.png') {
        $resultResizeFull = Images::resizeImg('.'.$uploaddir.$_SESSION['img'], $full_widht, $full_height, 'full');
        if($resultResizeFull['message'] !== 'ok') {
            $_SESSION['info'] = 'Зміна розміру зображення на повний розмір пройшла з помилками.<br>'.$resultResizeFull['message'];
            $_SESSION['img'] = 'default.png';
            $errors['resizeImg'] = $_SESSION['info'];
        }
        $resultResizeMini = Images::resizeImg('.'.$uploaddir.$_SESSION['img'], $mini_widht, $mini_height, 'mini');
        if($resultResizeMini['message'] !== 'ok') {
            $_SESSION['info'] = 'Зміна розміру зображення на мініатюру пройшла з помилками.<br>'.$resultResizeMini['message'];
            $_SESSION['img'] = 'default.png';
            $errors['resizeImg'] = $_SESSION['info'];
        }
        if(!count($errors)) {
            q("
                UPDATE `users` SET
                `img`      = '".es($_SESSION['img'])."'
                WHERE `id` = '".es($_SESSION['user']['id'])."'
            ");

            $_SESSION['info'] = 'Профайл користувача вдало змінено!';

            unlink('.'.$uploaddir.$_SESSION['img']);
            if($_SESSION['img'] !== $_SESSION['user']['img']) {
                unlink(realpath('.'.$uploaddir.'full/'.$_SESSION['user']['img']));
                unlink(realpath('.'.$uploaddir.'mini/'.$_SESSION['user']['img']));
            }

            if(isset($_SESSION['img'])) {
                unset($_SESSION['img']);
            }
            
            header("Location: /profile");
            exit();
        }
    }
}

if(isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    unset($_SESSION['info']);
}