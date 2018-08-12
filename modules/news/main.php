<?php
Core::$META['title'] = 'Розділ новин';

Pagination::$onpage = 2;
Pagination::$curpage = (int)(isset($_GET['pag']) ? $_GET['pag'] : 1);

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

$cat = q("
    SELECT `name`
    FROM `news_cat`
");