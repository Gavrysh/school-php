<?php
if (isset($_GET['route'])){
    $temp = explode ('/', $_GET['route']);
    if ($temp[0] == 'admin') {
        Core::$CONT = Core::$CONT.'/admin';
        Core::$SKIN = 'admin';
        unset($temp[0]);
    }
    $i = 0;
    foreach ($temp as $key => $value) {
        if ($i == 0) {
            $_GET['module'] = $value;
        } elseif ($i == 1) {
            if (!empty($value)) {
                $_GET['page'] = $value;
            }
        } else {
            $_GET['key'.($key-1)] = $value;
        }
        ++$i;
    }
    unset($_GET['route']);
}

if (!isset($_GET['module'])) {
    $_GET['module'] = 'home';
} else {
    $res = q("
        SELECT *
        FROM `pages`
        WHERE `module` = '".es($_GET['module'])."'
        LIMIT 1
    ");
    
    if(!mysqli_num_rows($res)) {
        header("Location: /errors/404");
        exit();
    } else {
        $staticpage = mysqli_fetch_assoc($res);
        if($staticpage['static'] == 1) {
            $_GET['module'] = 'staticpage';
            $_GET['page'] = 'main';
        }
    }

    $res->close();
    DB::close();

}

if (!isset($_GET['page'])) {
    $_GET['page'] = 'main';
}

if(!preg_match('#^[a-z-_]*$#iu', $_GET['page']) && !preg_match('#^404$#iu', $_GET['page'])) {
    header("Location: /errors/404");
    exit();
}