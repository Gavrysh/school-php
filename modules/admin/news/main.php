<?php
Core::$META['title'] = 'Розділ новин';

Pagination::$onpage = 2;
Pagination::$curpage = (int)(isset($_GET['pag']) ? $_GET['pag'] : 1);

if (isset($_POST['add'])) {
    header("Location: /admin/news/add");
    exit();
}

if (isset($_POST['showCat'])) {
    header("Location: /admin/news/show_cat");
    exit();
}

$addon = '';
if (isset($_GET['cat'])) {
    $addon .= '?cat='.str_replace(' ', '+', $_GET['cat']);
    $news = Pagination::q("
        SELECT *
        FROM `news`
        WHERE `cat` = '".es($_GET['cat'])."'
        ORDER BY `id` DESC
    ");
} elseif (isset($_GET['search'])) {
    $addon .= '?search='.str_replace(' ', '+', $_GET['search']);
    $news = Pagination::q("
        SELECT *
        FROM `news`
        WHERE `title` LIKE '%".es($_GET['search'])."%'
        ORDER BY `id` DESC
    ");
} else {
    $news = Pagination::q("
        SELECT * FROM `news`
        ORDER BY `id` DESC
    ");
}

if(isset($_POST['delete'])) {
    if(isset($_POST['ids'])) {
        foreach($_POST['ids'] as $k => $v) {
            $_POST['ids'][$k] = (int)$v;
        }

        $ids = implode(',', $_POST['ids']);

        q("
            DELETE FROM `news`
            WHERE `id` IN (".$ids.")
        ");

        $_SESSION['info'] = 'Новини були успішно видалені';
        header("Location: /admin/news");
        exit();
    }
}

if(isset($_GET['key2'], $_GET['key3']) && $_GET['key2'] == 'delete') {
    q("
        DELETE FROM `news`
        WHERE `id` = ".(int)$_GET['key3']."
    ");

    $_SESSION['info'] = 'Новина була успішно видалена';
    header("Location: /admin/news");
    exit();
}

$cat = q("
    SELECT `name`
    FROM `news_cat`
");

if (isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    unset($_SESSION['info']);
}