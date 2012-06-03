<?php
    define('PATH',dirname(__FILE__));
    define('APP_PATH', PATH.'/Application/');
    set_include_path(PATH.'/Eruda/');
    require_once 'Eruda/Eruda_Router.php';
    require_once 'Eruda/Eruda_CF.php';
    require_once APP_PATH.'routeMap.php';
?>
