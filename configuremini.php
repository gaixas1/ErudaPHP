<?php
    define('PATH',dirname(__FILE__));
    define('APP_PATH', PATH.'/Application/');
    define('PUB_PATH', PATH.'/public/');
    $router = unserialize(file_get_contents (PATH.'/router.rt'));
    Eruda::setRouter($router);
    Eruda_Environment::init('Fallensoul', 'http://localhost/', 5, 'admin@fallensoul.es');

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