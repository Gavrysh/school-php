<?php
include './modules/allpages.php';
if($_SERVER['REQUEST_URI'] != '/admin' && !isset($_SESSION['user'])) {
    header("Location: /cab/auth");
    exit();
}