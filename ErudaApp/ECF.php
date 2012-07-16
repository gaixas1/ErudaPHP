<?php
/**
 * Description of eCF
 * Eruda Framework Controller & Function
 * Set of Controller and Function for a given method
 *
 * @author gaixas1
 */
class eCF {
    public static $methods = array('DEFAULT'=>0, 'GET'=>1, 'POST'=>2, 'PUT'=>3, 'DELETE'=>4, 'HEAD'=>5);
    
    protected $meth;
    protected $ctrl;
    protected $fn;
    protected $data;
    
    function __construct($ctrl = 'Index', $function = 'Index', $method = 'DEFAULT') { 
        $this->meth = self::$methods[$method];
        $this->ctrl = $ctrl;
        $this->fn = $function;
    }
    
/**
* * Getters & Setters
**/
    
    function setMethod($method) {
        $this->meth = self::$methods[$method];
        return $this;
    }
    
    function getMethod() {
        return array_search($this->meth, self::$methods);
    }
    
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
    
    function setData($data) {
        $this->data = $data;
        return $this;
    }
    
    function getData() {
        return $this->data;
    }
}
?>