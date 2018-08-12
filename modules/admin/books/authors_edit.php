<?php
Core::$META['title'] = 'Редагування автора';
$errors = array();

//Папка для завантажених файлів
$uploaddir = '/uploaded/';
//Бажані розміри нового зображення у пікселях
$full_widht = 200;
$full_height = 200;
//Бажані розміри мініатюри, px
$mini_widht = 100;
$mini_height = 100;

$authors = q("
    SELECT * FROM `authors`
    WHERE `id` = ".(int)$_GET['key2']."
    LIMIT 1
");

if (!$authors->num_rows) {
    $_SESSION['info'] = 'Цей автор відсутній!';
    header("Location: /admin/books/authors");
    exit();
}

$rowAuthors = $authors->fetch_assoc();
$authors->close();
DB::close();

if (isset($_POST['edit'], $_POST['name'], $_POST['biography'])) {
	
	if (mb_strlen($_POST['name']) < 6) {
        $errors['name'] = 'Ім\'я занадто коротке';
    } elseif (mb_strlen($_POST['name']) > 100) {
        $errors['name'] = 'Ім\'я занадто довге';
    }
    if (empty($_POST['biography'])) {
        $errors['biography'] = 'Треба додати біографію автора!';
    }

    if ($_FILES['file']['name'] != '') {
        $r_upload = Images::uploadImg($_FILES['file']['name'], $_FILES['file']['tmp_name']);
        if ($r_upload['new_name'] !== 'noname') {
            if (isset($_SESSION['authorsAddImg']) && $_SESSION['authorsAddImg'] != '') {
                unlink('.'.$uploaddir.$_SESSION['authorsAddImg']);
                unlink('.'.$uploaddir.'full/'.$_SESSION['authorsAddImg']);
                unlink('.'.$uploaddir.'mini/'.$_SESSION['authorsAddImg']);
            }
            $_SESSION['authorsAddImg'] = $r_upload['new_name'];
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
            $_SESSION['authorsAddImg'] = 'authorsDefault.png';
            $errors['upload'] = 'Завантаження файлу пройшло з помилками!<br>'.$r_upload['error'];
        }
    }

    if(!count($errors)) {
        if (isset($_SESSION['authorsAddImg']) && $_SESSION['authorsAddImg'] != $rowAuthors['img']) {
            if (isset($rowAuthors['img']) && $rowAuthors['img'] != '') {
                unlink('.'.$uploaddir.'full/'.$rowAuthors['img']);
                unlink('.'.$uploaddir.'mini/'.$rowAuthors['img']);
            }
            $authorsAddImg = $_SESSION['authorsAddImg'];
        } else {
            $authorsAddImg = $rowAuthors['img'];
        }
        q("
            UPDATE `authors` SET
            `name`      = '".es($_POST['name'])."',
            `biography` = '".es($_POST['biography'])."',
            `img`       = '".es($authorsAddImg)."'
            WHERE `id`  = ".(int)$_GET['key2']."
        ");

        $_SESSION['info'] = 'Запис був успішно відредагований!';

        if(isset($_SESSION['authorsAddImg'])) {
            unlink('.'.$uploaddir.$_SESSION['authorsAddImg']);
            unset($_SESSION['authorsAddImg']);
        }

        header("Location: /admin/books/authors");
        exit();
    }
}

if (isset($_POST['name'], $_POST['biography'])) {
    foreach ($rowAuthors as $key => $value) {
        if($key != 'id' && $key !='img') {
            $rowAuthors[$key] = $_POST[$key];
        }
    }
}

if(isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    unset($_SESSION['info']);
}