<?php
    session_start();
    set_include_path('ApplicationMini/');
    require_once 'Eruda_Loader.php';
    require_once 'configurecron.php';
    Eruda::runCron('backup');
?>