<?php
Core::$META['title'] = 'Список авторів книжок';
//Папка для завантажених файлів
$uploaddir = '/uploaded/';

$output = array();

function bookWithAuthor($books) {
    $booksId = array();
    while ($row = $books->fetch_assoc()) {
        $booksId[] = $row['id'];
        $output[] = $row;
    }
    unset($row);

    $bId = implode(',', $booksId);

    $authors = q("
        SELECT *
        FROM `books2authors`
        WHERE `id_book` IN (".$bId.")
    ");

    $authorsId = array();
    while ($row = $authors->fetch_assoc()) {
        $authorsId[] = $row['id_author'];
        $b2a[] = $row;
    }
    unset($row);
    $authors->close();
    $aId = implode(',', $authorsId);

    $authors = q("
        SELECT `id`, `name`
        FROM `authors`
        WHERE `id` IN (".$aId.")
    ");
    while ($row = $authors->fetch_assoc()) {
        foreach ($b2a as $key => $value) {
            if ($b2a[$key]['id_author'] == $row['id']) {
                $b2a[$key]['nameAuthor'] = $row['name'];
            }
        }
    }
    
    unset($row);
    $authors->close();

    foreach ($output as $key => $value) {
        $output[$key]['nameAuthor'] = '';
        foreach ($b2a as $k => $v) {
            if ($output[$key]['id'] == $b2a[$k]['id_book']) {
                $output[$key]['nameAuthor'] .= $b2a[$k]['nameAuthor'].'. ';
            }
        }
    }
    return $output;
}

if (isset($_POST['searchBook'])) {
    $books = q("
        SELECT *
        FROM `books`
        WHERE `name` LIKE '%".es($_POST['searchBook'])."%'
    ");
    if ($books->num_rows) {
        $output = bookWithAuthor($books);
    }
} else {
    $authors = q("
        SELECT *
        FROM `authors`"
        .(isset($_POST['searchAuthor']) ?  ' WHERE `name` LIKE \'%'.es($_POST['searchAuthor']).'%\'' : '')
    );
}

if (isset($_POST['books'])) {
    header("Location: /books");
    exit();
}

if(isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    unset($_SESSION['info']);
}