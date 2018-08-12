<?php
Core::$META['title'] = 'Додавання товару';

//Папка для завантажених файлів
$uploaddir = '/uploaded/';
//Бажані розміри нового зображення у пікселях
$full_widht = 200;
$full_height = 200;
//Бажані розміри мініатюри, px
$mini_widht = 100;
$mini_height = 100;

$category = eNumArray('goods', 'category');
$availability = eNumArray('goods', 'availability');

if(isset($_POST['add'], $_POST['code'], $_POST['category'], $_POST['header'], $_POST['availability'], $_POST['description'], $_POST['delivery'], $_POST['warranty'], $_POST['price'])) {

    $errors = array();
    if(empty($_POST['code'])) {
        $errors['code'] = 'Не вказаний код товару!';
    }
    if(empty($_POST['category'])) {
        $errors['category'] = 'Не вказана категорія товару!';
    }
    if(empty($_POST['header'])) {
        $errors['header'] = 'Не вказаний заголовок товару!';
    }
    if(empty($_POST['availability'])) {
        $errors['availability'] = 'Не вказана наявність товару!';
    }
    if(empty($_POST['description'])) {
        $errors['description'] = 'Не корректний або відсутній опис товару!';
    }
    if(empty($_POST['delivery'])) {
        $errors['delivery'] = 'Не вказана інформація про доставку товару!';
    }
    if(empty($_POST['warranty'])) {
        $errors['warranty'] = 'Не вказана інформація по гарантії товару!';
    }
    if(empty($_POST['price'])) {
        $errors['price'] = 'Не вказана ціна товару!';
    }

    if ($_FILES['file']['name'] != '') {
        if (isset($_SESSION['goodsAddImg']) && $_SESSION['goodsAddImg'] != '') {
            unlink('.'.$uploaddir.$_SESSION['goodsAddImg']);
            unlink('.'.$uploaddir.'full/'.$_SESSION['goodsAddImg']);
            unlink('.'.$uploaddir.'mini/'.$_SESSION['goodsAddImg']);
        }
        $r_upload = Images::uploadImg($_FILES['file']['name'], $_FILES['file']['tmp_name']);
        if($r_upload['new_name'] !== 'noname') {
            $_SESSION['goodsAddImg'] = $r_upload['new_name'];
        } else {
            $_SESSION['goodsAddImg'] = 'goodsDefault.png';
            $errors['upload'] = 'Завантаження файлу пройшло з помилками!<br>'.$r_upload['error'];
        }
    } else {
        if (isset($_SESSION['goodsAddImg'])) {
            $r_upload['new_name'] = $_SESSION['goodsAddImg'];
        } else {
            $r_upload['new_name'] = 'goodsDefault.png';
        }
    }
    
    if(isset($_SESSION['goodsAddImg']) && $_SESSION['goodsAddImg'] !== 'goodsDefault.png' && $_SESSION['goodsAddImg']) {
        $resultResizeFull = Images::resizeImg('.'.$uploaddir.$_SESSION['goodsAddImg'], $full_widht, $full_height, 'full');
        if($resultResizeFull['message'] !== 'ok') {
            $_SESSION['info'] = 'Зміна розміру зображення на повний розмір пройшла з помилками.<br>'.$resultResizeFull['message'];
            $_SESSION['goodsAddImg'] = 'goodsDefault.png';
            $errors['resizeImg'] = $_SESSION['info'];
        }
        $resultResizeMini = Images::resizeImg('.'.$uploaddir.$_SESSION['goodsAddImg'], $mini_widht, $mini_height, 'mini');
        if($resultResizeMini['message'] !== 'ok') {
            $_SESSION['info'] = 'Зміна розміру зображення на мініатюру пройшла з помилками.<br>'.$resultResizeMini['message'];
            $_SESSION['goodsAddImg'] = 'goodsDefault.png';
            $errors['resizeImg'] = $_SESSION['info'];
        }
    } else {
        $_SESSION['goodsAddImg'] = '';
    }

    if(!count($errors)) {
        q("
            INSERT INTO `goods` SET
            `code`          = '".es($_POST['code'])."',
            `category`      = '".es($_POST['category'])."',
            `date`          = NOW(),
            `header`        = '".es($_POST['header'])."',
            `availability`  = '".es($_POST['availability'])."',
            `description`   = '".es($_POST['description'])."',
            `delivery`      = '".es($_POST['delivery'])."',
            `warranty`      = '".es($_POST['warranty'])."',
            `price`         = ".(float)$_POST['price'].",
            `img`           = '".es($_SESSION['goodsAddImg'])."'
        ");

        $_SESSION['info'] = 'Запис був успішно доданий!';
        
        unlink('.'.$uploaddir.$_SESSION['goodsAddImg']);
        
        if(isset($_SESSION['goodsAddImg'])) {
            unset($_SESSION['goodsAddImg']);
        }

        header("Location: /admin/goods");
        exit();
    }
}

if(isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    unset($_SESSION['info']);
}