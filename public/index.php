<?php
    set_include_path('../Application/');
    require_once 'Eruda/Eruda_Loader.php';
    
    Eruda::init();
    require_once '../configure.php';
    
    Eruda::parseUri();
    
    Eruda::runController();
    
    Eruda::show();
   
?>