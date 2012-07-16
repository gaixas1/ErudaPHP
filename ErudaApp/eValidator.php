<?php
/**
 * Description of eValidator
 * Eruda Form Field Validator
 * ABSTRACT CLASS
 *
 * @author gaixas1
 */
abstract class eValidator {
    protected $error;
    abstract function valid($val);
    
    function get_error(){
        return $this->error;
    }
}
?>