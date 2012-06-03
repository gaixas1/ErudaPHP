<?php
/**
 * Description of Eruda_Loader
 *
 * @author gaixas1
 */

function __autoload($class_name) {
    if(is_file($class_name));
        include $class_name . '.php';
}
?>
