<?php
Core::$META['title'] = 'Додавання автора';
//Папка для завантажених файлів
$uploaddir = '/uploaded/';

//Бажані розміри нового зображення у пікселях
$full_widht = 200;
$full_height = 200;
//Бажані розміри мініатюри, px
$mini_widht = 100;
$mini_height = 100;

if (isset($_POST['add'], $_POST['name'], $_POST['biography'])) {
	$errors = array();

	if (mb_strlen($_POST['name']) < 6) {
        $errors['name'] = 'Ім\'я автора занадто коротке (від 6 до 255 символів)';
    } elseif (mb_strlen($_POST['name']) > 100) {
        $errors['name'] = 'Ім\'я автора занадто довге (від 6 до 255 символів)';
    }
    if (empty($_POST['biography'])) {
        $errors['biography'] = 'Треба додати біографію автора!';
    }

    if ($_FILES['file']['name'] != '') {
        if (isset($_SESSION['authorsAddImg']) && $_SESSION['authorsAddImg'] != '') {
            unlink('.'.$uploaddir.$_SESSION['authorsAddImg']);
            unlink('.'.$uploaddir.'full/'.$_SESSION['authorsAddImg']);
            unlink('.'.$uploaddir.'mini/'.$_SESSION['authorsAddImg']);
        }
        $r_upload = Images::uploadImg($_FILES['file']['name'], $_FILES['file']['tmp_name']);
        if ($r_upload['new_name'] !== 'noname') {
            $_SESSION['authorsAddImg'] = $r_upload['new_name'];
        } else {
            $_SESSION['authorsAddImg'] = 'authorsDefault.png';
            $errors['upload'] = 'Завантаження файлу пройшло з помилками!<br>'.$r_upload['error'];
        }
    } else {
        if (isset($_SESSION['authorsAddImg'])) {
            $r_upload['new_name'] = $_SESSION['authorsAddImg'];
        } else {
            $r_upload['new_name'] = 'authorsDefault.png';
        }
    }
    
    if (isset($_SESSION['authorsAddImg']) && $_SESSION['authorsAddImg'] !== 'authorsDefault.png' && $_SESSION['authorsAddImg'] != '') {
        $resultResizeFull = Images::resizeImg('.'.$uploaddir.$_SESSION['authorsAddImg'], $full_widht, $full_height, 'full');
        if($resultResizeFull['message'] !== 'ok') {
            $_SESSION['info'] = 'Зміна розміру зображення на повний розмір пройшла з помилками.<br>'.$resultResizeFull['message'];
            $_SESSION['authorsAddImg'] = 'authorsDefault.png';
            $errors['resizeImg'] = $_SESSION['info'];
        }
        $resultResizeMini = Images::resizeImg('.'.$uploaddir.$_SESSION['authorsAddImg'], $mini_widht, $mini_height, 'mini');
        if($resultResizeMini['message'] !== 'ok') {
            $_SESSION['info'] = 'Зміна розміру зображення на мініатюру пройшла з помилками.<br>'.$resultResizeMini['message'];
            $_SESSION['authorsAddImg'] = 'authorsDefault.png';
            $errors['resizeImg'] = $_SESSION['info'];
        }
    } else {
        $_SESSION['authorsAddImg'] = '';
    }

    if(!count($errors)) {
    	q("
            INSERT INTO `authors` SET
            `name`      = '".es($_POST['name'])."',
            `biography` = '".es($_POST['biography'])."',
            `img`       = '".es($_SESSION['authorsAddImg'])."'
        ");

        $_SESSION['info'] = 'Запис був успішно доданий!';
        
        unlink('.'.$uploaddir.$_SESSION['authorsAddImg']);
        
        if(isset($_SESSION['authorsAddImg'])) {
            unset($_SESSION['authorsAddImg']);
        }

        header("Location: /admin/books/authors");
        exit();
    }
}

if(isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    unset($_SESSION['info']);
}