<?php

if(isset($_GET['hash'], $_GET['key1'])) {
  q("
    UPDATE `users` SET
    `active` = 'активний'
    WHERE `hash` = '".es($_GET['hash'])."'
    AND `id` = ".(int)($_GET['key1'])."
  ");
  $info = 'Ви вдало активовані на сайті';
} else {
  $info = 'Ви пройшли за невірним посиланням';
}