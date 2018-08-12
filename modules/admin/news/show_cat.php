<?php
Core::$META['title'] = 'Категорії новин';

$res = q("
    SELECT * FROM `news_cat`
");

if (isset($_POST['add'])) {
	if (isset($_POST['name'])) {
		$errors = array();
		if (mb_strlen($_POST['name']) < 5 ) {
			$errors['name'] = 'Назва категорії занадто мала!';
		} elseif (mb_strlen($_POST['name']) > 30) {
			$errors['name'] = 'Назва категорії занадто велика!';
		}
	}

	if (!count($errors)) {
		$resAdd = q("
			SELECT *
			FROM `news_cat`
			WHERE `name` LIKE '%".es($_POST['name'])."%'
			LIMIT 1
		");
		if ($resAdd->num_rows) {
			$row = $resAdd->fetch_assoc();
			$resAdd->close();
			DB::close();
			$errors['name'] = 'Схожий розділ вже існує! '.$row['name'];
		} else {
			q("
				INSERT INTO `news_cat` SET
				`name` = '".es($_POST['name'])."'
			");

			$_SESSION['info'] = 'Запис був успішно доданий!';
	        header("Location: /admin/news/show_cat");
	        exit();
		}
	}
}

if (isset($_POST['delete'], $_POST['gns'])) {
    foreach($_POST['gns'] as $k => $v) {
        $_POST['gns'][$k] = (int)$v;
    }

    $gns = implode(',', $_POST['gns']);

    q("
        DELETE FROM `news_cat`
        WHERE `id` IN (".$gns.")
    ");

    $_SESSION['info'] = 'Відмічені категорії новин були успішно видалені';
    header("Location: /admin/news/show_cat");
    exit();
}

if (isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    unset($_SESSION['info']);
}