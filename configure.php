<?php
/* @var $Eruda Eruda */
/* @var $router Eruda_Router */

    define('PATH',dirname(__FILE__));
    define('APP_PATH', PATH.'/Application/');
    require_once APP_PATH.'routeMap.php';
    Eruda::setRouter($router);
    Eruda::setEnvironment(new Eruda_Environment('Fallensoul', '/', 5));
    
    Eruda::setDBConnector(
        new Eruda_DBConnector_MYSQLi('localhost', 'erudablog', 'root', 'root')
    );
    
    Eruda::addFolder('css', 'http://fallensoul.es/template/');
    
    
?>
