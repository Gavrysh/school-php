<?php
Core::$META['title'] = 'Перегляд новини';

$news = q("
    SELECT * FROM `news`
    WHERE `id` = ".(int)$_GET['key1']."
    LIMIT 1
");

if (!$news->num_rows) {
    $_SESSION['info'] = 'Цієї новини не існує!';
    header("Location: /news");
    exit();
}

$row = $news->fetch_assoc();
$news->close();
DB::close();