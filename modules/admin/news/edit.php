<?php
Core::$META['title'] = 'Редагування новини';

$res = q("
    SELECT `name` FROM `news_cat`
");

if (isset($_POST['edit'], $_POST['title'], $_POST['cat'], $_POST['description'], $_POST['text'])) {
    $errors = array();
    if(empty($_POST['title'])) {
        $errors['title'] = 'Ви не заповнили заголовок новини';
    }
    if(empty($_POST['cat'])) {
        $errors['cat'] = 'Треба ввести категорію';
    }
    if(empty($_POST['description'])) {
        $errors['description'] = 'Треба зробити опис новини';
    }
    if(empty($_POST['text'])) {
        $errors['text'] = 'Треба зробити повний текст новини';
    }

    if(!count($errors)) {      

        q("
            UPDATE `news` SET
            `date`          = NOW(),
            `title`         = '".es($_POST['title'])."',
            `cat`           = '".es($_POST['cat'])."',
            `description`   = '".es($_POST['description'])."',
            `text`          = '".es($_POST['text'])."'
            WHERE `id`      = ".(int)($_GET['key2'])."
        ");

        $_SESSION['info'] = 'Запис був успішно відредагований!';
        header("Location: /admin/news");
        exit();
    }
}

$news = q("
    SELECT * FROM `news`
    WHERE `id` = ".(int)($_GET['key2'])."
    LIMIT 1
");

if (!$news->num_rows) {
    $_SESSION['info'] = 'Цієї новини не існує!';
    header("Location: /admin/news");
    exit();
}

$row = $news->fetch_assoc();
$news->close();
DB::close();

if (isset($_POST['edit'], $_POST['title'], $_POST['cat'], $_POST['description'], $_POST['text'])) {
    foreach ($row as $key => $value) {
        if($key != 'id' && $key != 'date' && $key != 'meta_title' && $key != 'meta_keywords' && $key != 'meta_description') {
            $row[$key] = $_POST[$key];
        }        
    }
}