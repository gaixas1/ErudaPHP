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
        
    } else if(preg_match('~^Eruda_Interface_.*$~', $class_name)) {                      //Interface
        if(is_file($inc.'Interfaces/'.$class_name.'.php'))
            include 'Interfaces/'.$class_name . '.php';
        else if(is_file($inc.'Eruda/Interfaces/'.$class_name.'.php'))
            include 'Eruda/Interfaces/'.$class_name . '.php';
        else
            throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
        
        
    } else if(preg_match('~^Eruda_Helper_.*$~', $class_name)) {                      //Helpers
        if(is_file($inc.'Helpers/'.$class_name.'.php'))
            include 'Helpers/'.$class_name . '.php';
        else if(is_file($inc.'Eruda/Models/'.$class_name.'.php'))
            include 'Eruda/Helpers/'.$class_name . '.php';
        else
            throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
        
    } else if(preg_match('~^Eruda_Controller_.*$~', $class_name)) {                      //Controller
        if(is_file($inc.'Controllers/'.$class_name.'.php'))
            include 'Controllers/'.$class_name . '.php';
        else if(is_file($inc.'Eruda/Controllers/'.$class_name.'.php'))
            include 'Eruda/Controllers/'.$class_name . '.php';
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
        
    } else if(preg_match('~^Eruda_MV_.*$~', $class_name)) {                       //MV
        if(is_file($inc.'MV/'.$class_name.'.php'))
            include 'MV/'.$class_name . '.php';
        else if(is_file($inc.'Eruda/MV/'.$class_name.'.php'))
            include 'Eruda/MV/'.$class_name . '.php';
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
        
    } else if(preg_match('~^Eruda_Validator_.*$~', $class_name)) {                //Validator
        if(is_file($inc.'Validators/'.$class_name.'.php'))
            include 'Validators/'.$class_name . '.php';
        else if(is_file($inc.'Eruda/Validators/'.$class_name.'.php'))
            include 'Eruda/Validators/'.$class_name . '.php';
        else
            throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
        
    } else if(preg_match('~^Eruda_Mailer_.*$~', $class_name)) {                //Mailer
        if(is_file($inc.'Mailers/'.$class_name.'.php'))
            include 'Mailers/'.$class_name . '.php';
        else if(is_file($inc.'Eruda/Mailers/'.$class_name.'.php'))
            include 'Eruda/Mailers/'.$class_name . '.php';
        else
            throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
        
        
    } else if(is_file($inc.'Extra/'.$class_name.'.php'))
        include 'Extra/'.$class_name . '.php';
    else if(is_file($inc.'Eruda/Extra/'.$class_name.'.php'))
        include 'Eruda/Extra/'.$class_name . '.php';
    else
        throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
        
}
?>
