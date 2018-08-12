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
    header("Location: /admin/books");
    exit();
}

if (isset($_POST['authorsAdd'])) {
    header("Location: /admin/books/authors_add");
    exit();
}

if(isset($_POST['authorsDelete'], $_POST['gns'])) {
    $a = array();
    for ($k = 0; $k< count($_POST['gns']); ++$k) {
        $a[] = $_POST['gns'][$k];
    }

    $res = q("
        SELECT `img`
        FROM `authors`
        WHERE `id` IN (".implode(',', $a).")
    ");
    while($row = $res->fetch_assoc()) {
        if ($row['img'] != '') {
            unlink('.'.$uploaddir.$row['img']);
            unlink('.'.$uploaddir.'full/'.$row['img']);
            unlink('.'.$uploaddir.'mini/'.$row['img']);
        }
    }

    $res->close();
    DB::close();

    q("
        DELETE FROM `authors`
        WHERE `id` IN (".implode(',', $a).")
    ");
    q("
        DELETE FROM `books2authors`
        WHERE `id_author` IN (".implode(',', $a).")
    ");
    unlink($a);

    $_SESSION['info'] = 'Відмічені автори були успішно видалені';
    header("Location: /admin/books/authors");
    exit();
}

if(isset($_SESSION['authorsAddImg'])) {
    unset($_SESSION['authorsAddImg']);
}

if(isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    unset($_SESSION['info']);
}