<?php
/* @var $Eruda Eruda */
/* @var $router Eruda_Router */

    define('PATH',dirname(__FILE__));
    define('APP_PATH', PATH.'/Application/');
    require_once APP_PATH.'routeMap.php';
    Eruda::setRouter($router);
   // Eruda::setEnvironment(new Eruda_Environment('Fallensoul', 'http://localhost/', 5, 'admin@fallensoul.es'));
    Eruda::setEnvironment(new Eruda_Environment('Fallensoul', 'http://192.168.1.2/', 5, 'admin@fallensoul.es'));
    
    Eruda::setDBConnector(
        new Eruda_DBConnector_MYSQLi('localhost', 'erudablog', 'root', '')
    );
    Eruda::setMailer(
        new Eruda_Mailer_SMPT('admin@fallensoul.es', 'gaixas1','smtp.gmail.com', 'admin@fallensoul.es', 'sergio')
    );
    
    Eruda::addFolder('css', '/css/');
    Eruda::addFolder('js', '/js/');
    Eruda::addFolder('img', '/img/');
    
?>
