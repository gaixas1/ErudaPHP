<?php
/**
 * Description of Eruda_CF
 *
 * @author gaixas1
 */

//**comVersion**namespace ErudaSystem;

class Eruda_CF {
    public static $_methods = array('DEFAULT', 'GET', 'POST', 'PUT', 'DELETE', 'HEAD');
    protected $_meth;
    protected $_cont;
    protected $_func;
    protected $_data;
    
    function __construct($controller = null, $function = null, $method = 'DEFAULT') { 
        if($method!=null && is_string($method) && in_array($method, Eruda_CF::$_methods)) {
            $this->_meth = $method;
            if($controller!=null && is_string($controller) && strlen($controller)>0) {
                $this->_cont = $controller;
            } else {
                $this->_cont = 'Index';
            }
            if($function!=null && is_string($function) && strlen($function)>0) {
                $this->_func = $function;
            } else {
                $this->_func = 'Index';
            }
        } else {
            throw new Exception('Eruda_CF::__construct - BAD REQUEST METHOD : '.$method);
        }
    }
    
    function setMethod($method) {
        $this->_meth = $method;
        return $this;
    }
    function getMethod() {
        return $this->_meth;
    }
    
    function setController($controller) {
        $this->_cont = $controller;
        return $this;
    }
    function getController() {
        return $this->_cont;
    }
    
    function setFunction($function) {
        $this->_func = $function;
        return $this;
    }
    function getFunction() {
        return $this->_func;
    }
    
    function setData($data) {
        $this->_data = $data;
        return $this;
    }
    function getData() {
        return $this->_data;
    }
}

?>
