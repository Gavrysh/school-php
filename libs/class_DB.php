<?php
/*
ALIAS
q(); Запит
es(); mysqli_real_escape_string

РОБОТА З ОБ'ЄКТОМ ВИБІРКИ
$res->q(); - Запит із поверненням результату
$res->num_rows; - Кількість повернутих строк - mysqli_num_rows();
$res->fetch_assoc(); - Дістаємо запис - mysqli_fetch_assoc();
$res->close(); - Чистимо результат вибірки

РОБОТА З ВЖЕ ПІД'ЄДНАННОЮ MySQL
DB::_()->affected_rows; - Кількість змінених записів
DB::_()->insert_id; - Останній ID вставки
DB::_()->real_escape_string(); - Аналог es()
DB::_()->query(); - Аналог q()
DB::_()->multi_query(); - Числені запити
DB::close(); - Закриття з'єднання з БД
*/

class DB 
{
    static public $mysqli = array();
    static public $connect = array();
    static public $errors = array();

    static public function _($key = 0) 
    {
        if (!isset(self::$mysqli['$key'])) {
            if (!isset(self::$connect['server'])) {
                self::$connect['server'] = Core::$DB_LOCAL;
            }
            if (!isset(self::$connect['user'])) {
                self::$connect['user'] = Core::$DB_LOGIN;
            }
            if (!isset(self::$connect['pass'])) {
                self::$connect['pass'] = Core::$DB_PASS;
            }
            if (!isset(self::$connect['db'])) {
                self::$connect['db'] = Core::$DB_NAME;
            }

            if (!count(self::$mysqli)) {
                self::$mysqli[$key] = @new mysqli(self::$connect['server'], self::$connect['user'], self::$connect['pass'], self::$connect['db']);
                if (mysqli_connect_errno()) {
                    self::$errors[$connect] = 'Не вдала спроба під\'єднатись до Бази Даних';
                    exit;
                } else {
                    //echo 'connected<br>';
                }
                if (!self::$mysqli[$key]->set_charset("utf8")) {
                    self::$errors[$charset] = 'Помилка завантаження набору символів utf8:'.self::$mysqli[$key]->error;
                    exit;
                }
            }
        }
        if (!count(self::$errors)) {
            return self::$mysqli[$key];
        }
    }

    static public function close($key = 0) 
    {
        self::$mysqli[$key]->close();
        unset(self::$mysqli[$key]);
    }
}