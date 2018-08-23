<?php
Core::$META['title'] = 'Чат - спілкування у реальному часі';

/**
 * Універсальна функція виборки
 */
function universal($query)
{
    $res = q("$query");

    while ($row = $res->fetch_assoc()) {
        $array[] = $row;
    }

    $res->close();
    unset($row);

    return $array;
}

/**
 * Вибираємо усіх користувачив (активних доопрацювати)
 */
$users = universal('SELECT `name`, `access`, `img`, `access_chat` FROM `users`');

/**
 * Вибираємо 10 останніх записів чату (кількість регулюється у кабінеті користувача - доопрацювати)
 */
$notices = universal('SELECT * FROM `chat` LIMIT 10');
