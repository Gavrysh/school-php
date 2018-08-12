<?php
Core::$META['title'] = 'Розділ коментарів';

$output = array();
$output['status'] = true;
$errors = array();

$res = q("
    SELECT * FROM `comments`
    ORDER BY `id`
    DESC
");

$max_id = q("
    SELECT MAX(`id`) AS `id` FROM `comments`
");

$row = $max_id->fetch_assoc();
$max_id->close();

$_SESSION['max_id'] = $row['id'];
unset($row);

if (isset($_GET['key2'], $_GET['key3']) && $_GET['key2'] == 'delete') {
    q("
        DELETE FROM `comments`
        WHERE `id` = ".(int)($_GET['key3'])."
    ");

    $_SESSION['info'] = 'Коментар був успішно видалений';

    header("Location: /admin/comments");
    exit();
}

if (isset($_POST['name'], $_POST['email'], $_POST['comment'])) {
    if(!isset($_SESSION['user']) || (isset($_SESSION['user']) && 'не активний' == $_SESSION['user']['active'])) {
        $errors['user'] = 'Записи можна додавати лише авторизованим користувачам!<br> Будь ласка, <a href="/cab/registration">зареєструйтесь</a>, або <a href="/cab/auth">авторизуйтесь</a> на сайті.';
    }
    if (3 > mb_strlen($_POST['name'])) {
        $errors['name'] = 'Треба вказати ім\'я (від 3 до 16 символів)';
    }
    if (6 > mb_strlen($_POST['comment'])) {
        $errors['comment'] = 'Треба щось написати (від 6 символів)';
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Треба вказати коректно e-mail адресу';
    }

    if (count($errors)) {
        $output['status'] = false;
        echo json_encode($errors);
        exit;
    } else {
        q("
            INSERT INTO `comments` SET
            `name`     = '".es($_POST['name'])."',
            `email`    = '".es($_POST['email'])."',
            `comment`  = '".es($_POST['comment'])."'
        ");

        $comments = q("
            SELECT * FROM `comments`
            WHERE `id` > ".(int)$_SESSION['max_id']."
        ");

        $i = 1;
        while ($row = $comments->fetch_assoc()) {
            $output[$i]['id'] = $row['id'];
            $output[$i]['name'] = $row['name'];
            $output[$i]['date'] = $row['date'];
            $output[$i]['comment'] = $row['comment'];
            $i++;
        }
        $comments->close();
        unset($row);
        
        echo json_encode($output);
        exit;
    }
}

if(isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    unset($_SESSION['info']);
}