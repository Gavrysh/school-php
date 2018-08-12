<?php
Core::$META['title'] = 'Перегляд товару';
//Папка для завантажених файлів
$uploaddir = '/uploaded/';

if(isset($_GET['key2'])) {
       
  $goods = q("
        SELECT * FROM `goods`
        WHERE `id` = ".(int)$_GET['key2']."
        LIMIT 1
        ");
  
    if (!mysqli_num_rows($goods)) {
        $_SESSION['info'] = 'Цього товару не існує!';
        header("Location: /admin/goods");
        exit();
    }

    $row = mysqli_fetch_assoc($goods);
}

if (isset($_POST['edit'])) {
    $edit = '/admin/goods/edit/'.(int)$_GET['key2'];
    header("Location: $edit");
    exit();
}

if (isset($_POST['delete'])) {
    q("
        DELETE FROM `goods`
        WHERE `id` = ".(int)$_GET['key2']."
    ");
    if ($row['img'] != '') {
        unlink('.'.$uploaddir.$row['img']);
        unlink('.'.$uploaddir.'full/'.$row['img']);
        unlink('.'.$uploaddir.'mini/'.$row['img']);
    }
    $_SESSION['info'] = 'Запис був успішно видалений!';
    header("Location: /admin/goods");
    exit();
}