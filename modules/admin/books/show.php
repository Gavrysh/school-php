<?php
Core::$META['title'] = 'Перегляд книжки';

//Папка для завантажених файлів
$uploaddir = '/uploaded/';

if(isset($_GET['key2'])) {
    $books = q("
        SELECT * FROM `books`
        WHERE `id` = ".(int)($_GET['key2'])."
        LIMIT 1
    ");
  
    if (!$books->num_rows) {
        $_SESSION['info'] = 'Цієї книжки не існує!';
        header("Location: /admin/books");
        exit();
    }

    $rowBooks = $books->fetch_assoc();
    $books->close();
    DB::close();

    $authors = q("
        SELECT `id_author`
        FROM `books2authors`
        WHERE `id_book` = ".(int)($_GET['key2'])."
    ");
    
    if ($authors->num_rows) {
        while ($row = $authors->fetch_assoc()) {
            $authorsId[] = $row['id_author'];
        }
        $authors->close();
        unset($row);

        $authors = q("
            SELECT `id`,`name`
            FROM `authors`
            WHERE `id` IN (".implode(',', $authorsId).")
        ");
        while ($row = $authors->fetch_assoc()) {
            $a[] = $row;
        }
        $authors->close();
        DB::close();
    }
}

if (isset($_POST['edit'])) {
    $edit = '/admin/books/edit/'.(int)($_GET['key2']);
    header("Location: $edit");
    exit();
}

if (isset($_POST['delete'])) {
    q("
        DELETE FROM `books`
        WHERE `id` = ".(int)$_GET['key2']."
    ");
    q("
        DELETE FROM `books2authors`
        WHERE `id_book` = ".(int)$_GET['key2']."
    ");
    if ($rowBooks['img'] != '') {
        unlink('.'.$uploaddir.$rowBooks['img']);
        unlink('.'.$uploaddir.'full/'.$rowBooks['img']);
        unlink('.'.$uploaddir.'mini/'.$rowBooks['img']);
    }
    $_SESSION['info'] = 'Запис був успішно видалений!';
    header("Location: /admin/books");
    exit();
}