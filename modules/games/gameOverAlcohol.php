<?php

if (isset($_POST['playagain'])) {
    header("Location: /games/gameAlcohol");
    exit();
} elseif(isset($_POST['playnone'])) {
    header("Location: /index.php");
    exit();
} else {
    $user = '<img src="/img/gameoveruser.jpg" alt="user">';
    $server = '<img src="/img/gameoverserver.jpg" alt="server">';
}