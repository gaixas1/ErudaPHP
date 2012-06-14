<?php
/**
 * Description of Eruda_Validator
 *
 * @author gaixas1
 */
abstract class Eruda_Validator {
    protected $error;
    abstract function valid($val);
    
    function get_error(){
        return $this->error;
    }
}

?>
