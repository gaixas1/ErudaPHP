<?php
/**
 * Description of Eruda_CF
 *
 * @author gaixas1
 */

class Eruda_CF {
    /**
     * @var $_methods array(string)
     * @var $_meth string
     * @var $_cont string
     * @var $_func string
     * @var $_data array
     */
    public static $_methods = array('DEFAULT', 'GET', 'POST', 'PUT', 'DELETE', 'HEAD');
    
    protected $_meth;
    protected $_cont;
    protected $_func;
    protected $_data;
    
    /**
     * @param string $controller
     * @param string $function
     * @param string $method
     * @throws Exception 
     */
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
    
    /**
     * @param string $method
     * @return \Eruda_CF 
     */
    function setMethod($method) {
        $this->_meth = $method;
        return $this;
    }
    
    /**
     * @return string 
     */
    function getMethod() {
        return $this->_meth;
    }
    
    /**
     * @param string $controller
     * @return \Eruda_CF 
     */
    function setController($controller) {
        $this->_cont = $controller;
        return $this;
    }
    
    /**
     * @return string 
     */
    function getController() {
        return $this->_cont;
    }
    
    /**
     * @param string $function
     * @return \Eruda_CF 
     */
    function setFunction($function) {
        $this->_func = $function;
        return $this;
    }
    /**
     * @return string 
     */
    function getFunction() {
        return $this->_func;
    }
    
    /**
     * @param array $data
     * @return \Eruda_CF 
     */
    function setData($data) {
        $this->_data = $data;
        return $this;
    }
    
    /**
     * @return array
     */
    function getData() {
        return $this->_data;
    }
}

?>
