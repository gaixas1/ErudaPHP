<?php
    session_start();
    set_include_path('../ApplicationMini/');
    require_once 'Eruda_Loader.php';
    
    Eruda::init();
    require_once '../configuremini.php';
    
    Eruda::parseUri();
    Eruda::runController();
    Eruda::show();  
?>