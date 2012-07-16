<?php
/**
 * Description of __autoload
 * Eruda default autoload class/interface function
 *
 * @author gaixas1
 */
function __autoload($class_name) {
    $inc = ini_get('include_path');
    
    if(is_file($inc.$class_name.'.php')) {
        //file on AppRoot
        include $class_name . '.php';return;
    } 
    
    if(is_file($inc.'includes/'.$class_name.'.php')) { 
        //file on AppRoot/includes
        include 'includes/'.$class_name . '.php'; return;
    }
    
    $file = str_replace('_', '/', $class_name).'.php';
    if(is_file($inc.$file)){
        //file on class path
        include $file;
    }
    
    throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
}
?>