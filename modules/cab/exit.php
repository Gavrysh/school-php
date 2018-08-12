<?php
setcookie("autoAuth", "", time()-3600, "/");
session_unset();
session_destroy();
header("Location: /");
exit();