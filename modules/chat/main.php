<?php
Core::$META['title'] = 'Чат';

function smile($st)
{
    return preg_replace('#\[:ch([\d]+):\]#uis', '<img src="/skins/default/img/ch$1.png" alt="smile" width="30px" height="30px">', $st);
}

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
    for ($i = 0; $row = $res->fetch_assoc(); ++$i) {
        $output[$i]['date'] = date('d.m.Y h:i:s', $row['date']);
        $output[$i]['user'] = $row['user'];
        $output[$i]['text'] = smile($row['text']);
    }
    $res->close();
    unset($row);
    if (isset($_SESSION['user'])) {
        $output['access'] = $_SESSION['user']['access'];
    }
}

$output = array();
$output['status'] = true;
$errors = array();

$listUsers = q("
    SELECT *
    FROM `users`
    ORDER BY `access` DESC
");

for ($i = 0; $row = $listUsers->fetch_assoc(); ++$i) {
    if (isset($_SESSION['user']) && ($_SESSION['user']['access'] == 'administrator' || $_SESSION['user']['access'] == 'moderator')) {
        if ($row['access_chat'] == 'дозволено') {
            $btn = 'btn-bun.png';
            $btnTitle = 'Забанити!';
        } else {
            $btn = 'btn-unbun.png';
            $btnTitle = 'Розбанити!';
        }
        $outUsers[$i]['btn'] = '<img id="btn-ban-unbun" src="/skins/default/img/'.$btn.'" alt="btn-ban" width="30px" height="30px" title="'.$btnTitle.'" onclick="banUnban($(this).parent())">';
    } else {
        $outUsers[$i]['btn'] = '';
    }
    $row['access'] == 'administrator' || $row['access'] == 'moderator' ? $ico = '<img src="/uploaded/admin.png" alt="chat-ico" width="20px" height="20px">' : $ico = '';
    $outUsers[$i]['ico'] = $ico;
    $outUsers[$i]['name'] = '<span id="chat-user" onclick="addUserMsg(this.innerHTML)">'.$row['name'].'</span>';
}
unset($row);
$listUsers -> close();

$chat = q("
    SELECT * FROM `chat`
    ORDER BY `id` DESC
    LIMIT 5
");

for ($i = 0; $row = $chat->fetch_assoc(); ++$i) {
    $outChat[$i]['text'] = '<span class="notice-date">'.$row['date'].'</span> <span class="notice-user">'.$row['user'].'</span><br><span class="notice-text">'.smile($row['text']).'</span><br>';
}
unset($row);
$chat -> close();

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
    echo json_encode($outChat);
    exit;
}