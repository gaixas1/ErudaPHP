<?php
    session_start();
    require_once '../configuremini.php';
    eCore::parseUri();
    eCore::runController();
    eCore::show();  
?>