<?php
Core::$META['title'] = 'Додавання новини';

$res = q("
    SELECT `name` FROM `news_cat`
");

if (isset($_POST['add'], $_POST['title'], $_POST['cat'], $_POST['description'], $_POST['text'])) {
    $errors = array();
    if (empty($_POST['title'])) {
        $errors['title'] = 'Ви не заповнили заголовок новини';
    }
    if (empty($_POST['cat'])) {
        $errors['cat'] = 'Треба ввести категорію';
    }
    if (empty($_POST['description'])) {
        $errors['description'] = 'Треба зробити опис новини';
    }
    if (empty($_POST['text'])) {
        $errors['text'] = 'Треба зробити повний текст новини';
    }

    if(!count($errors)) {        

        q("
            INSERT INTO `news` SET
            `date`             = NOW(),
            `title`            = '".es($_POST['title'])."',
            `cat`              = '".es($_POST['cat'])."',
            `description`      = '".es($_POST['description'])."',
            `text`             = '".es($_POST['text'])."',
            `meta_title`       = '".es($_POST['title'])."',
            `meta_keywords`    = '".es($_POST['title'])."',
            `meta_description` = '".es($_POST['title'])."'
        ");

        $_SESSION['info'] = 'Запис був успішно доданий!';
        header("Location: /admin/news");
        exit();
    }
}