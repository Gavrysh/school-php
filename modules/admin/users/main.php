<?php
Core::$META['title'] = 'Розділ користувачів';
if (isset($_SESSION['user'])) {

    if (isset($_POST['filter-role'], $_POST['access'])) {
        $users = q("
            SELECT * FROM `users`
            WHERE `access` = '".es($_POST['access'])."'
            ORDER BY `id`
        ");
    } elseif (isset($_POST['search-btn'], $_POST['search'])) {
        $users = q("
            SELECT * FROM `users`
            WHERE `login` LIKE '%".es($_POST['search'])."%'
            ORDER BY `id`
        ");
    } elseif (isset($_POST['delete'], $_POST['gns'])) {
        foreach ($_POST['gns'] as $k => $v) {
            $_POST['gns'][$k] = (int)$v;
        }

        $gns = implode(',', $_POST['gns']);

        q("
            DELETE FROM `users`
            WHERE `id` IN (".$gns.")
        ");

        $_SESSION['info'] = 'Відмічені користувачі були успішно видалені';
        header("Location: /admin/users");
        exit();
    } else {
        $users = q("
            SELECT * FROM `users`
            ORDER BY `id`
        ");
    }
    
    if (isset($_POST['add'])) {
        header("Location: /admin/users/add");
        exit();
    }

    $access = eNumArray('users', 'access');

    if (isset($_SESSION['info'])) {
        $info = $_SESSION['info'];
        unset($_SESSION['info']);
    }
    
} else {
    header("Location: /cab/auth");
    exit();
}