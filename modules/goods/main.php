<?php
Core::$META['title'] = 'Розділ товарів';
//Папка для завантажених файлів
$uploaddir = '/uploaded/';

$goods = q("
    SELECT * FROM `goods`
    ORDER BY `code`
");