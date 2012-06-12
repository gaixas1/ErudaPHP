<?php
/**
 * Description of Eruda_View
 *
 * @author gaixas1
 */

abstract class Eruda_Model {
    
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
    
    function __construct($vals = array()){
        if(is_array($vals))
            foreach($vals as $key=> $value) 
                $this->__set($key, $value);
    }
    
    abstract function __toString();
}
?>
