<?php
    set_include_path('../Eruda/');
    require_once 'Eruda_Loader.php';
    
    $t1 = microtime(true);
    $Eruda = new Eruda_Core();
    require_once '../configure.php';
    $t2 = microtime(true);
    
    echo $t1.' - '.$t2.' => '.($t2-$t1).'
';
    
    $t1 = microtime(true);
    require_once 'serialized.php';
    $t2 = microtime(true);
    
    echo $t1.' - '.$t2.' => '.($t2-$t1).'
';
    
    $t1 = microtime(true);
    require_once 'base64.php';
    $t2 = microtime(true);
    
    echo $t1.' - '.$t2.' => '.($t2-$t1).'
';
    
    /*
    $Eruda->parseUri();
    
    $Eruda->addFolder('css', 'http://fallensoul.es/template/');
    
    
    $header = new Eruda_Header_HTML();
    
    $header->setType('HTML5');
    $header->setMetatag('Description', 'FallenSoulFansub, todos nuestros mangas on-line para tu disfrute.');
    $header->addCSS('basic.css');
    
    $header->append2Title("Fallensoul")->append2Title('Anime')->prepend2Title('manga')->setTitleSeparator(' : ');
    $header->addKeyword('anime')->addKeyword('manga')->addKeyword('FallenSoul')->addKeyword('Manga');
    $header->printDOCTYPE();
    */
?>
