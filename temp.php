<?php
session_start();
include './libs/default.php';

//$size = getimagesize('./uploaded/20170316-145050img16185.jpg');
preg_match('#([\w\d-]+)([\w\d-]+)\.([a-z]+)$#iu', '/uploaded/20170320-122306img48702.jpg', $matches);
wtf($matches, 1);
echo $matches[0];


echo '<pre>';

echo 'COOKIE<br>';
print_r($_COOKIE);

echo 'SESSION<br>';
print_r($_SESSION);

echo 'SERVER<br>';
print_r($_SERVER);

echo 'POST<br>';
print_r($_POST);

echo 'GET<br>';
print_r($_GET);

echo 'REQUEST<br>';
print_r($_REQUEST);

echo 'FILES<br>';
print_r($_FILES);

echo '</pre>';

$subject = '[:ch03:]user2[:ch04:]';
$pattern = '[:ch03:]';
preg_match_all('#\[:ch([\d]+):\]#uis', $subject, $matches);
echo '<pre>';
print_r($matches);
echo '</pre>';
echo preg_replace('#\[:ch([\d]+):\]#uis', '<img src="skins/default/img/ch$1.png" alt="smile" width="30px" height="30px">', $subject);