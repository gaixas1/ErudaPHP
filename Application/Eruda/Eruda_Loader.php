<?php
/**
 * Description of Eruda_Loader
 *
 * @author gaixas1
 */

function __autoload($class_name) {
    $inc = ini_get('include_path');
    if(is_file($inc.'Eruda/'.$class_name.'.php')) {
        include 'Eruda/'.$class_name . '.php';
    } else if(preg_match('~^Eruda_View_.*$~', $class_name)) {
        if(is_file($inc.'Eruda/Views/'.$class_name.'.php'))
            include 'Eruda/Views/'.$class_name . '.php';
        else
            throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
    } else if(preg_match('~^Eruda_Header_.*$~', $class_name)) {
        if(is_file($inc.'Eruda/Headers/'.$class_name.'.php'))
            include 'Eruda/Headers/'.$class_name . '.php';
        else
            throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
        
    } else if(preg_match('~^Eruda_DBConnector_.*$~', $class_name)) {
        if(is_file($inc.'Eruda/Connectors/'.$class_name.'.php'))
            include 'Eruda/Connectors/'.$class_name . '.php';
        else
            throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
        
    } else{
            throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
    }
}
?>
