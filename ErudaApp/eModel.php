<?php
/**
 * Description of eModel
 * Eruda Model
 * Eruda data containers
 * ABSTRACT CLASS
 *
 * @author gaixas1
 */
abstract class eModel {
    function __construct($vals = array()){
        if(is_array($vals))
            foreach($vals as $key=> $value) 
                $this->__set($key, $value);
    }
    
    function __set($attr, $value){
        if(method_exists($this, 'set_' . $attr)){
            call_user_func(array($this, 'set_' . $attr), $value);
        }
    }
    function __get($attr){
        if(method_exists($this, 'get_' . $attr)){
            return call_user_func(array($this, 'get_' . $attr));
        }
    }
    abstract function __toString();
}
?>