<?php
Core::$META['title'] = 'Перегляд книжки';

//Папка для завантажених файлів
$uploaddir = '/uploaded/';

if(isset($_GET['key1'])) {
	$books = q("
	    SELECT * FROM `books`
	    WHERE `id` = ".(int)($_GET['key1'])."
	    LIMIT 1
	");
  
    if (!$books->num_rows) {
        $_SESSION['info'] = 'Цієї книжки не існує!';
        header("Location: /books");
        exit();
    }

    $rowBooks = $books->fetch_assoc();
    $books->close();
    DB::close();

    $authors = q("
        SELECT `id_author`
        FROM `books2authors`
        WHERE `id_book` = ".(int)($_GET['key1'])."
    ");
    
    while ($row = $authors->fetch_assoc()) {
        $authorsId[] = $row['id_author'];
    }
    unset($row);
    $authors->close();

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