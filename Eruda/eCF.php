<?php
/**
 * Description of eCF
 * Eruda Framework Controller & Function
 * Set of Controller and Function for a given method
 *
 * @author gaixas1
 */
class eCF {
    protected $cont;
    protected $fn;
    
    function __construct($ctrl = 'Index', $function = 'Index', $method = 'DEFAULT') { 
        $this->cont = $ctrl;
        $this->fn = $function;
    }
    
/**
* * Getters & Setters
**/
    
    function setController($controller) {
        $this->cont = $controller;
        return $this;
    }
    
    function getController() {
        return $this->cont;
    }
    
    function setFunction($function) {
        $this->fn = $function;
        return $this;
    }
    
    function getFunction() {
        return $this->fn;
    }
}
?>