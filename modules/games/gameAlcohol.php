<?php

$user = array(
    "user1.jpg", 
    "user2.jpg", 
    "user3.jpg", 
    "user4.jpg"
);
$server = array(
    "comp1.jpg", 
    "comp2.jpg", 
    "comp3.jpg", 
    "comp4.jpg"
);

    $user_hit = 0;
    $server_block = 0;
    $gamer_pass = 0;
    $server_pass = 0;
 
if (!isset($_SESSION['server'], $_SESSION['gamer']) ) {
    $_SESSION['server'] = 10;
    $_SESSION['gamer'] = 10;
} else {    
    if (isset($_POST['hit'])) {
        $errors = array();

        if (empty($_POST['hit'])) {
            $errors['hit'] = 'Ви не заповнили коректно поле';
        } elseif($_POST['hit'] < 1 || $_POST['hit'] > 3) {
            $errors['hit'] = 'Повинно бути ціле число від 1 до 3';
        }

        if (!count($errors)) {
            $user_hit = $_POST['hit'];
            $server_block = rand(1, 3);
            if ($server_block == (int)$_POST['hit']) {
                $gamer_pass = rand(1, 4);
                $_SESSION['gamer'] -= $gamer_pass;
            } else {
                $server_pass = rand(1, 4);
                $_SESSION['server'] -= $server_pass;
            }
        }
    }
    
    if ($_SESSION['gamer'] <= 0 || $_SESSION['server'] <= 0) {
        header("Location: /games/gameOverAlcohol");
        exit();
    }
}