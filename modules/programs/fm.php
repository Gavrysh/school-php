<?php

if(isset($_GET['link'])) {
    $dir = $_GET['link'].'/';
} else {
    $dir = './';
}

$fldr = array();
$fls = array();
$files = scandir($dir);

foreach($files as $v) {
    if(is_dir($dir.$v) && $v !== '.') {
        $fldr[] = '<a href="/programs/fm/?link='.urlencode($dir.$v).'"><img src="/img/folder.png" alt="folder" class="fldr-file"> '.$v.'</a><br>';
    } elseif($v !='.') {
        $fls[] = '<img src="/img/file.png" alt="file" class="fldr-file"> '.$v.'<br>';
    }
}