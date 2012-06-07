<?php
    set_include_path('../Application/');
    require_once 'Eruda/Eruda_Loader.php';
    
    Eruda_Core::init();
    require_once '../configure.php';
    
    Eruda_Core::parseUri();
    Eruda_Core::addFolder('css', 'http://fallensoul.es/template/');
    
    
    $header = new Eruda_Header_HTML();
    
    $header->setType('HTML5');
    $header->setMetatag('Description', 'FallenSoulFansub, todos nuestros mangas on-line para tu disfrute.');
    $header->addCSS('basic.css');
    
    $header->append2Title("Fallensoul");
    $header->addKeyword('anime')->addKeyword('manga')->addKeyword('FallenSoul')->addKeyword('Manga');
    $header->printDOCTYPE();
    
    $connector = new Eruda_DBConnector_MYSQLi('localhost','erudablog','root', 'root');
    $connector->connect();
    
    $connector->insertOne('user', array('id','name','level'), array(1,'gaixas1', 10));
    $afected = $connector->insertMulti('user', array('name'), array(array('user1'),array('user2'),array('user3'),array('user4')));
    $id= $connector->lastID();
   
?>

<html>
<?php 
    $header->printHeader($Eruda->getFolders());
?>
    <body>
        LastInsertered ID = <?php echo $id;?>
        Afected rows = <?php echo $afected;?>
    </body>
</html>