<?php
Core::$META['title'] = 'Додавання книжки';

//Папка для завантажених файлів
$uploaddir = '/uploaded/';
//Бажані розміри нового зображення у пікселях
$full_widht = 200;
$full_height = 200;
//Бажані розміри мініатюри, px
$mini_widht = 100;
$mini_height = 100;

//Виборка усіх авторів
$authors = q("
    SELECT *
    FROM `authors`
");

if (isset($_POST['add'], $_POST['name'], $_POST['pages'], $_POST['publication'], $_POST['price'], $_POST['annotation'])) {
	$errors = array();

	if (mb_strlen($_POST['name']) < 6) {
        $errors['name'] = 'Назва книги занадто коротка (від 6 до 255 символів)';
    } elseif (mb_strlen($_POST['name']) > 255) {
        $errors['name'] = 'Назва книги занадто довга (від 6 до 255 символів)';
    }
    if (!isset($_POST['gns'])) {
        $errors['authors'] = 'Треба обрати хоч одного автора!';
    }
    if (empty($_POST['pages'])) {
        $errors['pages'] = 'Не вказана кількість сторінок';
    }
    if (empty($_POST['publication'])) {
        $errors['publication'] = 'Не вказаний рік публікації';
    }
    if (empty($_POST['price'])) {
        $errors['price'] = 'Не вказана ціна товару!';
    }
    if (empty($_POST['annotation'])) {
        $errors['annotation'] = 'Треба додати короткий опис до книги, аннотацію!';
    }

    if ($_FILES['file']['name'] != '') {
        if (isset($_SESSION['booksAddImg']) && $_SESSION['booksAddImg'] != '') {
            unlink('.'.$uploaddir.$_SESSION['booksAddImg']);
            unlink('.'.$uploaddir.'full/'.$_SESSION['booksAddImg']);
            unlink('.'.$uploaddir.'mini/'.$_SESSION['booksAddImg']);
        }
        $r_upload = Images::uploadImg($_FILES['file']['name'], $_FILES['file']['tmp_name']);
        if ($r_upload['new_name'] !== 'noname') {
            $_SESSION['booksAddImg'] = $r_upload['new_name'];
        } else {
            $_SESSION['booksAddImg'] = 'booksDefault.png';
            $errors['upload'] = 'Завантаження файлу пройшло з помилками!<br>'.$r_upload['error'];
        }
    } else {
        if (isset($_SESSION['booksAddImg'])) {
            $r_upload['new_name'] = $_SESSION['booksAddImg'];
        } else {
            $r_upload['new_name'] = 'booksDefault.png';
        }
    }
    
    if (isset($_SESSION['booksAddImg']) && $_SESSION['booksAddImg'] !== 'booksDefault.png' && $_SESSION['booksAddImg'] != '') {
        $resultResizeFull = Images::resizeImg('.'.$uploaddir.$_SESSION['booksAddImg'], $full_widht, $full_height, 'full');
        if($resultResizeFull['message'] !== 'ok') {
            $_SESSION['info'] = 'Зміна розміру зображення на повний розмір пройшла з помилками.<br>'.$resultResizeFull['message'];
            $_SESSION['booksAddImg'] = 'booksDefault.png';
            $errors['resizeImg'] = $_SESSION['info'];
        }
        $resultResizeMini = Images::resizeImg('.'.$uploaddir.$_SESSION['booksAddImg'], $mini_widht, $mini_height, 'mini');
        if($resultResizeMini['message'] !== 'ok') {
            $_SESSION['info'] = 'Зміна розміру зображення на мініатюру пройшла з помилками.<br>'.$resultResizeMini['message'];
            $_SESSION['booksAddImg'] = 'booksDefault.png';
            $errors['resizeImg'] = $_SESSION['info'];
        }
    } else {
        $_SESSION['booksAddImg'] = '';
    }

    if(!count($errors)) {
    	q("
            INSERT INTO `books` SET
            `name`                 = '".es($_POST['name'])."',
            `pages`                = ".(int)($_POST['pages']).",
            `publication`          = '".es($_POST['publication'])."',
            `price`                = ".(float)$_POST['price'].",
            `annotation`           = '".es($_POST['annotation'])."',
            `img`                  = '".es($_SESSION['booksAddImg'])."'
        ");

        $book_id = DB::_()->insert_id;
        $a = array();
        for ($k = 0; $k< count($_POST['gns']); ++$k) {
            $a[] = '('.(int)($book_id).','.$_POST['gns'][$k].')';
        }
        q("
            INSERT INTO `books2authors` VALUES ".implode(', ', $a)."
        ");

        $_SESSION['info'] = 'Запис був успішно доданий!';

        unlink('.'.$uploaddir.$_SESSION['booksAddImg']);
        
        if(isset($_SESSION['booksAddImg'])) {
            unset($_SESSION['booksAddImg']);
        }

        header("Location: /admin/books");
        exit();
    }
}

if(isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    unset($_SESSION['info']);
}