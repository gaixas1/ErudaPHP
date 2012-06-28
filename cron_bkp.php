<?php
    session_start();
    set_include_path('Application/');
    require_once 'Eruda/Eruda_Loader.php';
    require_once 'configure.php';
    Eruda::runCron('backup');
?>