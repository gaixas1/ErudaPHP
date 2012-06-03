<?php
    set_include_path('../Eruda/');
    require_once 'Eruda_Loader.php';
    require_once '../configure.php';
    
    
    
    
    /**
     * @var $router Eruda_Router 
     */
    $data = array();
    var_dump($router->run('', 'DEFAULT', $data));
?>
