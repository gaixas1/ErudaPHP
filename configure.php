<?php
/* @var $Eruda Eruda_Core */
/* @var $router Eruda_Router */

    define('PATH',dirname(__FILE__));
    define('APP_PATH', PATH.'/Application/');
    require_once APP_PATH.'routeMap.php';
    
    $Eruda->setRouter($router);
?>
