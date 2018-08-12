<?php
Core::$META['title'] = 'Коментар (редагування)';
if(isset($_SESSION['user'])) {
    if (isset($_POST['name'], $_POST['email'], $_POST['comment'])) {
        $errors = array();
        if (empty($_POST['name'])) {
            $errors['name'] = 'Ви не заповнили поле "Ім\'я"';
        }
        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Ви не заповнили коректно e-mail';
        }
        if (empty($_POST['comment'])) {
            $errors['comment'] = 'Треба ввести коментар';
        }

        if(!count($errors)) {
            q("
                UPDATE `comments` SET
                `date`        = NOW(),
                `name`        = '".es($_POST['name'])."',
                `email`       = '".es($_POST['email'])."',
                `comment`     = '".es($_POST['comment'])."'
                WHERE `id`    = ".(int)($_GET['key2'])."
            ");

            $_SESSION['info'] = 'Запис був успішно відредагований!';
            header("Location: /admin/comments");
            exit();
        }
    }

    $comments = q("
        SELECT * FROM `comments`
        WHERE `id` = ".(int)($_GET['key2'])."
        LIMIT 1
    ");

    if (!mysqli_num_rows($comments)) {
        $_SESSION['info'] = 'Цього коментару не існує!';
        header("Location: /admin/comments");
        exit();
    }

    $row = mysqli_fetch_assoc($comments);

    if (isset($_POST['name'], $_POST['email'], $_POST['comment'])) {
        foreach ($row as $key => $value) {
            if($key != 'id' && $key != 'date') {
                $row[$key] = $_POST[$key];
            }        
        }
    }
} else {
    header("Location: /cab/auth");
    exit();
}