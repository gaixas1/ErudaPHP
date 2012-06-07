<?php
/* @var $Eruda Eruda */
/* @var $router Eruda_Router */

    define('PATH',dirname(__FILE__));
    define('APP_PATH', PATH.'/Application/');
    require_once APP_PATH.'routeMap.php';
    Eruda::setRouter($router);
    
    Eruda::setDBConnector(
        new Eruda_DBConnector_MYSQLi('localhost', 'erudablog', 'root', 'root')
    );
    
    Eruda::getDBConnector()->connect();
        
    foreach(Eruda_Mapper_Category::All() as $cat)
        var_dump($cat);
?>
