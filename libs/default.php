<?php

function wtf($array, $stop = false) {
    echo '<pre>'.print_r($array, 1).'</pre>';
    if (!$stop) {
        exit();
    }
}

function Copyright() {
    return 'Copyright &copy; '.(date('Y') > Core::$COPYRIGHT ? Core::$COPYRIGHT.' - '.date('Y') : Core::$COPYRIGHT).' ';
}

// Функція оболонка від mysqli_query з розширеним функціоналом,
// меншою кількістю вхідних параметрів, логіюванням у окремий файл
function q($query, $key = 0) {
    $res = DB::_($key)->query($query);
    if ($res === false) {
        $info = debug_backtrace();
        $error_log = strip_tags("Дата/час - ".date('d:m:y - H:i:s')."<br>\n"."Помилка у файлі - ".$info[0]['file']."<br>\n"."Рядок - ".$info[0]['line']."<br>\n"."Запит - ").htmlspecialchars($query).strip_tags("<br>\n"."Помилка mysqli - ".DB::_($key)->error."<br>\n");
        echo "Дата/час - ".date('d:m:y - H:i:s')."<br>\n"."Помилка у файлі - ".$info[0]['file']."<br>\n"."Рядок - ".$info[0]['line']."<br>\n"."Запит - ".htmlspecialchars($query)."<br>\n"."Помилка mysqli - ".DB::_($key)->error."<br>\n";
        file_put_contents('./logs/mysql.log', htmlspecialchars_decode($error_log)."\n\n", FILE_APPEND);
        exit();
    } else {
        return $res;
    }
}

// Прибирає зайві пробіли попереду та позаду строки
// (працює з вкладеним масивом рекурсійно)
function trimAll($el) {
    if (is_array($el)) {
        $el = array_map(trimAll, $el);
    } else {
        $el = trim($el);
    }
    return $el;
}

// Приводить змінну до типу int
// (працює з вкладеним масивом рекурсійно)
function intAll($el) {
    if (is_array($el)) {
        $el = array_map(intAll, $el);
    } else {
        $el = (int)$el;
    }
    return $el;
}

// Приводить змінну до типу float
// (працює з вкладеним масивом рекурсійно)
function floatAll($el) {
    if (is_array($el)) {
        $el = array_map(floatAll, $el);
    } else {
        $el = (float)$el;
    }
    return $el;
}

// Преобразує спец.символи до HTML-сутністі
// (працює з вкладеним масивом рекурсійно)
function hs($el) {
    if (is_array($el)) {
        $el = array_map(hs, $el);
    } else {
        $el = htmlspecialchars($el);
    }
    return $el;
}

// Екранує спец. символи для SQL-виразів
// (працює з вкладеним масивом рекурсійно)
function es($el, $key = 0) {
    if (is_array($el)) {
        $el = array_map(res, $el);
    } else {
        $el = DB::_($key)->real_escape_string($el);
    }
    return $el;
}

spl_autoload_register(function ($class_name) {
    include './libs/class_'.$class_name.'.php';
});

function myHash ($var) {
    $salt1 = 'DAYK';
    $salt2 = 'DINGA';
    return $var = crypt(md5($var.$salt1), $salt2);
}

//Повертає масив поля ENUM БД
//Вхідні параметри таблиця, поле (ENUM)
function eNumArray($table, $field, $key = 0) {
    
    $act = q("
        SHOW COLUMNS FROM `".$table."`
        WHERE FIELD='".$field."'
        ");
    
    $row = $act->fetch_assoc();
    
    $act->close();
    DB::close();

    preg_match("/^enum\(\'(.*)\'\)$/", $row['Type'], $matches);
    return $eNumArray = explode("','", $matches[1]);
}

//Повертає готовий select
function selectItems($items, $selected=0) {
    $text = '';
    foreach ($items as $key => $value) {
        if ($key === $selected) {
            $ch = ' selected';
        } else {
            $ch = '';
        }
        $text .= '<option'.$ch.' value='.$key.'>'.$value.'</option><br>';
    }
    return $text;
}