<?php
/**
 * Description of Eruda_Core
 *
 * @author gaixas1
 */

class Eruda_Core {
    protected $_router = null;
    protected $_base;
    
    /**
     * @param Eruda_Router $router 
     */
    function __construct($router=null, $base=null){
        if($router!=null)
            $this->setRouter($router);
        if($base!=null)
            $this->setBase($base);
        else
            $this->setBase('');
    }
    
    /**
     * @param Eruda_Router $router
     * @return \Eruda_Core
     * @throws Exception 
     */
    function setRouter($router) {
        if($router!= null && $router instanceof Eruda_Router) {
            $this->_router = $router;
        } else {
            throw new Exception('Eruda_Core::run - NOT VALID ROUTER');
        }
        return $this;
    }
    
    /**
     * @return Eruda_Router 
     */
    function getRouter(){
        return $this->_router;
    }
    
    /**
     * @param string $base
     * @return \Eruda_Core
     * @throws Exception 
     */
    function setBase($base) {
        if($base!= null && !is_string($base)) {
            $this->_base = $base;
        } else {
            throw new Exception('Eruda_Core::run - NOT VALID BASE');
        }
        return $this;
    }
    
    /**
     * @return string 
     */
    function getBase() {
        return $this->_base;
    }
    
}

?>
