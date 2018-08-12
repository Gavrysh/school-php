<?php
Core::$META['title'] = 'Редагування категорії новин';

$cat = q("
    SELECT * FROM `news_cat` 
    WHERE `id` = ".(int)($_GET['key2'])."
    LIMIT 1
");

if(!$cat->num_rows) {
    $_SESSION['info'] = 'Цієї категорії новин не існує!';
    header("Location: /admin/news/show_cat");
    exit();
}

$row = $cat->fetch_assoc();
$cat->close();
DB::close();

if (isset($_POST['name'])) {
	$errors = array();
	if (mb_strlen($_POST['name']) < 5 ) {
		$errors['name'] = 'Назва категорії занадто мала!';
	} elseif (mb_strlen($_POST['name']) > 30) {
		$errors['name'] = 'Назва категорії занадто велика!';
	}

	if (!count($errors)) {
		$resEdit = q("
			SELECT *
			FROM `news_cat`
			WHERE `name` LIKE '%".es($_POST['name'])."%'
			LIMIT 1
		");

		if ($resEdit->num_rows) {
			$row = $resEdit->fetch_assoc();
			$resEdit->close();
			DB::close();
			$errors['name'] = 'Схожий розділ вже існує! '.$row['name'];
		} else {
			q("
				UPDATE `news_cat` SET
				`name` = '".es($_POST['name'])."'
				WHERE `id` = ".(int)($_GET['key2'])."
			");
			$_SESSION['info'] = 'Запис був успішно відредагований!';
			header("Location: /admin/news/show_cat");
			exit();
		}
	}
}