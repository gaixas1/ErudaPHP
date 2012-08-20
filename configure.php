<?php
    define('PATH',dirname(__FILE__));
    define('APP_PATH', PATH.'/ErudaApp/');
    define('ERUDA_PATH', PATH.'/Eruda/');
    define('PUB_PATH', PATH.'/public/');
    
    require_once ERUDA_PATH.'eLoader.php';
    
    eCore::init();
    
    eCore::parseRouter(APP_PATH.'router.raw.rt');
    //eCore::loadRouter(APP_PATH.'router.rt');
    
    eCore::setDBConnector(
        new eDBConnector_MYSQLi('localhost', 'erudablog', 'root', '')
    );
    
    eCore::setMailer(
        new eMailer_SMPT('admin@fallensoul.es', 'gaixas1','smtp.gmail.com', 'admin@fallensoul.es', 'sergio')
    );
    
    eCore::addFolder('css', '/css/');
    eCore::addFolder('js', '/js/');
    eCore::addFolder('img', '/img/');
    
    eEnvironment::init('Eruda, PHP mini Framework', 'http://localhost/', 'admin@fallensoul.es');
    
?>