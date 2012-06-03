<?php
    set_include_path('../Eruda/');
    require_once 'Eruda_Loader.php';
    
    $Eruda = new Eruda_Core();
    require_once '../configure.php';
    
    
    echo $Eruda->parseUri();
    
?>
