<?php
    require_once '../configure.php';
    
/* @var $router Eruda_Router */
    $uris = array(
        '',
        '5fdsfads',
        '05805/dsad sa',
        '02510/d sad/',
        '02-2012/',
        '02-2012'
    );
    foreach($uris as $uri) {
        echo '<h1>- "'.$uri.'" </h1>';
        echo '<table>';
    foreach(Eruda_CF::$_methods as $method) {
        $params = array();
        $cf = $router->run($uri, $method, $params);
/* @var $cf Eruda_CF */
        echo '<tr>';
        echo '<td>'.$cf->getController().'</td>';
        echo '<td>'.$cf->getFunction().'</td>';
        echo '<td>'.$method.' -> '.$cf->getMethod().'</td>';
        echo '<td>';
        var_dump($cf->getData());
        echo '</td>';
        echo '</tr>';
    }
        echo '</table>';
    }
    
?>
