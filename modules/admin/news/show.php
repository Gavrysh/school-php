<?php
Core::$META['title'] = 'Перегляд новини';

$news = q("
    SELECT * FROM `news`
    WHERE `id` = ".(int)$_GET['key2']."
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