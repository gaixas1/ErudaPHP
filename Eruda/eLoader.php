<?php
/**
 * Description of __autoload
 * Eruda default autoload class/interface function
 *
 * @author gaixas1
 */
function __autoload($class_name) {
    if(is_file(APP_PATH.$class_name.'.php')) {
        //file on AppRoot
        include APP_PATH.$class_name . '.php';return;
    } 
    
    if(is_file(APP_PATH.'includes/'.$class_name.'.php')) { 
        //file on AppRoot/includes
        include APP_PATH.'includes/'.$class_name . '.php'; return;
    }
    
    $file = str_replace('_', '/', $class_name).'.php';
    if(is_file(APP_PATH.$file)){
        //file on class path
        include APP_PATH.$file;
    }
    
    if(is_file(ERUDA_PATH.$class_name.'.php')) {
        //file on ErudaRoot
        include ERUDA_PATH.$class_name . '.php';return;
    } 
    
    throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
}
?>