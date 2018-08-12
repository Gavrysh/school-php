<?php

if(isset($_SESSION['user'])) {
    header("Location: /admin/users");
    exit();
}
include './modules/cab/auth.php';
