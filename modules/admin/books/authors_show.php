<?php
Core::$META['title'] = 'Перегляд автора';
//Папка для завантажених файлів
$uploaddir = '/uploaded/';

$authors = q("
    SELECT *
    FROM `authors`
");

if(isset($_GET['key2'])) {
    $authors = q("
        SELECT * FROM `authors`
        WHERE `id` = ".(int)$_GET['key2']."
        LIMIT 1
    ");
  
    if (!$authors->num_rows) {
        $_SESSION['info'] = 'Інформація по цьому автору відсутня!';
        header("Location: /admin/books/authors");
        exit();
    }

    $rowAuthors = $authors->fetch_assoc();
    $authors->close();
    DB::close();

    $books = q("
        SELECT `id_book`
        FROM `books2authors`
        WHERE `id_author` = ".(int)($_GET['key2'])."
    ");

    if ($books->num_rows) {
        while ($row = $books->fetch_assoc()) {
            $booksId[] = $row['id_book'];
        }
        $books->close();
        unset($row);

        $books = q("
            SELECT `id`,`name`
            FROM `books`
            WHERE `id` IN (".implode(',', $booksId).")
        ");
        while ($row = $books->fetch_assoc()) {
            $a[] = $row;
        }
        $books->close();
        DB::close();
    }
}

if (isset($_POST['edit'])) {
    $edit = '/admin/books/authors_edit/'.(int)($_GET['key2']);
    header("Location: $edit");
}

if (isset($_POST['delete'])) {
    q("
        DELETE FROM `authors`
        WHERE `id` = ".(int)($_GET['key2'])."
    ");
    q("
        DELETE FROM `books2authors`
        WHERE `id_author` = ".(int)$_GET['key2']."
    ");
    if ($rowAuthors['img'] != '') {
        unlink('.'.$uploaddir.$rowAuthors['img']);
        unlink('.'.$uploaddir.'full/'.$rowAuthors['img']);
        unlink('.'.$uploaddir.'mini/'.$rowAuthors['img']);
    }
    $_SESSION['info'] = 'Запис був успішно видалений!';
    header("Location: /admin/books/authors");
    exit();
}