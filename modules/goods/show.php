<?php
Core::$META['title'] = 'Перегляд товару';
//Папка для завантажених файлів
$uploaddir = '/uploaded/';

if(isset($_GET['key1'])) {
       
    $goods = q("
        SELECT * FROM `goods`
        WHERE `id` = ".(int)$_GET['key1']."
        LIMIT 1
    ");
  
    if (!mysqli_num_rows($goods)) {
        $_SESSION['info'] = 'Цього товару не існує!';
        header("Location: /goods");
        exit();
    }

    $row = mysqli_fetch_assoc($goods);
}
