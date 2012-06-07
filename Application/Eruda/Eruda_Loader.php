<?php
/**
 * Description of Eruda_Loader
 *
 * @author gaixas1
 */

function __autoload($class_name) {
    $inc = ini_get('include_path');
    if(is_file($inc.$class_name.'.php')) {                                          //File on root
        include 'Eruda/'.$class_name . '.php';
    } else if(is_file($inc.'Eruda/'.$class_name.'.php')) {                          //File on Eruda root
        include 'Eruda/'.$class_name . '.php';
        
    } else if(preg_match('~^Eruda_Model_.*$~', $class_name)) {                      //Model
        if(is_file($inc.'Models/'.$class_name.'.php'))
            include 'Models/'.$class_name . '.php';
        else if(is_file($inc.'Eruda/Models/'.$class_name.'.php'))
            include 'Eruda/Models/'.$class_name . '.php';
        else
            throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
        
    } else if(preg_match('~^Eruda_Mapper_.*$~', $class_name)) {                      //Mapper
        if(is_file($inc.'Mappers/'.$class_name.'.php'))
            include 'Mappers/'.$class_name . '.php';
        else if(is_file($inc.'Eruda/Mappers/'.$class_name.'.php'))
            include 'Eruda/Mappers/'.$class_name . '.php';
        else
            throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
        
    } else if(preg_match('~^Eruda_View_.*$~', $class_name)) {                       //View
        if(is_file($inc.'Views/'.$class_name.'.php'))
            include 'Views/'.$class_name . '.php';
        else if(is_file($inc.'Eruda/Views/'.$class_name.'.php'))
            include 'Eruda/Views/'.$class_name . '.php';
        else
            throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
        
    } else if(preg_match('~^Eruda_Header_.*$~', $class_name)) {                     //Header
        if(is_file($inc.'Headers/'.$class_name.'.php'))
            include 'Headers/'.$class_name . '.php';
        else if(is_file($inc.'Eruda/Headers/'.$class_name.'.php'))
            include 'Eruda/Headers/'.$class_name . '.php';
        else
            throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
        
    } else if(preg_match('~^Eruda_DBConnector_.*$~', $class_name)) {                //DBConnector
        if(is_file($inc.'Connectors/'.$class_name.'.php'))
            include 'Connectors/'.$class_name . '.php';
        else if(is_file($inc.'Eruda/Connectors/'.$class_name.'.php'))
            include 'Eruda/Connectors/'.$class_name . '.php';
        else
            throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
        
        
    } else{
            throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
    }
}
?>
