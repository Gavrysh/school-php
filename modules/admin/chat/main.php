<?php
Core::$META['title'] = 'Чат';

function accessChat()
{
    $res = q("
        SELECT `access_chat`
        FROM `users`
        WHERE `id` = ".(int)$_SESSION['user']['id']."
    ");
    $row = $res->fetch_assoc();
    $res->close();
    return $row['access_chat'] == 'дозволено' ? true : false;
}

function loadNotice()
{
    global $output;
    $res = q("
        SELECT * FROM `chat`
        ORDER BY `id` DESC
        LIMIT 5
    ");
    $i = 1;
    while ($row = $res->fetch_assoc()) {
        $output[$i]['date'] = $row['date'];
        $output[$i]['user'] = $row['user'];
        $output[$i]['text'] = preg_replace('#\[:ch([\d]+):\]#uis', '<img src="/skins/admin/default/img/ch$1.png" alt="smile" width="30px" height="30px">', $row['text']);
        $i++;
    }
    $res->close();
    unset($row);
}

$output = array();
$output['status'] = true;
$errors = array();

$listUsers = q("
    SELECT `name`, `access`
    FROM `users`
    ORDER BY `access` DESC
");

$chat = q("
    SELECT * FROM `chat`
    ORDER BY `id` DESC
");

if (isset($_POST['notice'])) {
    if(!isset($_SESSION['user']) || (isset($_SESSION['user']) && 'не активний' == $_SESSION['user']['active'])) {
        $errors['user'] = 'Записи можна додавати лише авторизованим користувачам!<br> Будь ласка, <a href="/cab/registration">зареєструйтесь</a>, або <a href="/cab/auth">авторизуйтесь</a> на сайті.';
    } else {
        if (!accessChat()) {
            $errors['access_chat'] = 'Доступ на запис у чат заборонено! Зверніться до модератора за розясненнями.';
        }
        if (3 > mb_strlen($_POST['notice'])) {
            $errors['notice'] = 'Повідомлення у чат від 3 символів';
        }    
    }

    if (count($errors)) {
        $output['status'] = false;
        foreach ($errors as $key => $val) {
            $output['errors'][$key] = $val;
        }
    } else {
        q("
            INSERT INTO `chat` SET
            `date` = NOW(),
            `user` = '".es($_SESSION['user']['name'])."',
            `text` = '".es($_POST['notice'])."'
        ");

        loadNotice();
    }
    echo json_encode($output);
    exit;
}

if(isset($_POST['req'])) {
    loadNotice();
    echo json_encode($output);
    exit;
}