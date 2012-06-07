<?php
/* @var $Eruda Eruda */
/* @var $router Eruda_Router */

    define('PATH',dirname(__FILE__));
    define('APP_PATH', PATH.'/Application/');
    require_once APP_PATH.'routeMap.php';
    Eruda::setRouter($router);
    
    Eruda::setDBConnector(
        new Eruda_DBConnector_MYSQLi('localhost', 'erudablog', 'root')
    );
    
    Eruda::getDBConnector()->connect();
    
    
    $user = Eruda_Mapper_User::get(1);
    /*
    echo $user->get_id();
    */
    
?>
