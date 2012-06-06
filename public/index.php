<?php
    set_include_path('../Application/');
    require_once 'Eruda/Eruda_Loader.php';
    
    $Eruda = new Eruda_Core();
    require_once '../configure.php';
    
    $Eruda->parseUri();
    
    $Eruda->addFolder('css', 'http://fallensoul.es/template/');
    
    
    $header = new Eruda_Header_HTML();
    
    $header->setType('HTML5');
    $header->setMetatag('Description', 'FallenSoulFansub, todos nuestros mangas on-line para tu disfrute.');
    $header->addCSS('basic.css');
    
    $header->append2Title("Fallensoul")->append2Title('Anime')->prepend2Title('manga')->setTitleSeparator(' : ');
    $header->addKeyword('anime')->addKeyword('manga')->addKeyword('FallenSoul')->addKeyword('Manga');
    $header->printDOCTYPE();
?>

<html>
<?php 
    $header->printHeader($Eruda->getFolders());
?>
</html>