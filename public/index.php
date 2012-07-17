<?php
    session_start();
    require_once '../configure.php';
    eCore::parseUri();
    eCore::runController();
    eCore::show();  
?>