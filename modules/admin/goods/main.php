<?php
Core::$META['title'] = 'Розділ товарів';
//Папка для завантажених файлів
$uploaddir = '/uploaded/';


if(isset($_POST['delete'], $_POST['gns'])) {
    foreach($_POST['gns'] as $k => $v) {
        $_POST['gns'][$k] = (int)$v;
    }

    $gns = implode(',', $_POST['gns']);

    q("
        DELETE FROM `goods`
        WHERE `id` IN (".$gns.")
    ");

    $_SESSION['info'] = 'Відмічені товари були успішно видалені';
    header("Location: /admin/goods");
    exit();
}

$goods = q("
    SELECT * FROM `goods`
    ORDER BY `code`
");

if(isset($_SESSION['goodsAddImg'])) {
    unset($_SESSION['goodsAddImg']);
}

if(isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    unset($_SESSION['info']);
}