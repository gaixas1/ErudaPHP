<?php
/**
 * Description of Eruda_Router
 *
 * @author gaixas1
 */

//**comVersion**namespace ErudaSystem;

class Eruda_Router {
    protected $_def = array();
    protected $_err = array();
    protected $_ext = array();
    
    function __construct($def = null, $ext = array(), $err = null) {
        //Add default CF
        if($def!=null) {
            if($def instanceof Eruda_CF) {
                $this->addDef($def);
            } else if (is_array($def)){
                foreach ($def as $cf) {
                    $this->addDef($cf);
                }
            }
        } 
        if(count($this->_def)==0){
            $this->addDef(new Eruda_CF());
        }
        
        //Add error CF
        if($err!=null) {
            if($err instanceof Eruda_CF) {
                $this->addErr($err);
            } else if (is_array($err)){
                foreach ($err as $cf) {
                    $this->addErr($cf);
                }
            }
        } 
        if(count($this->_err)==0){
            $this->addErr(new Eruda_CF('Error', 'E404'));
        }
        
        //Add extra Routers
        if (is_array($ext)){
            foreach ($ext as $key => $router) {
                if($key!=null && is_string($key) && strlen($key)>0 && $router!=null && $router instanceof Eruda_Router) {
                    $this->addRouter($key,$router);
                }
            }
        } 
        
    }
    
    function addDef($cf) {
        if($cf!=null && $cf instanceof Eruda_CF) {
            $this->_def[$cf->getMethod()] = $cf;
        }
        return $this;
    }
    
    function addErr($cf) {
        if($cf!=null && $cf instanceof Eruda_CF) {
            $this->_err[$cf->getMethod()] = $cf;
        }
        return $this;
    }
    
    function addRouter($key, $router) {
        if($key!=null && is_string($key) && strlen($key)>0 && $router!=null && $router instanceof Eruda_Router) {
            $this->_err[$key] = $router;
        }
        return $this;
    }
    
    function run($uri, $method, &$params) {
        if(is_string($uri) && strlen($uri)>0) {
            foreach ($this->_ext as $key => $router) {
                if(preg_match('|$'.$key.'.*^|', $uri, $matches)) {
                    foreach ($matches as $value) {
                        $params[] = $value;
                    }
                    $uri = preg_replace ('|$'.$key.'.*^|', '', $uri);
                    return $router->run($uri, $method, $params);
                }
            }
        } else {
            if(isset($this->_def[$method])){
                return $this->_def[$method]->setData($params);
            } else if(isset($this->_def['DEFAULT'])){
                return $this->_def['DEFAULT']->setData($params);
            }
        }
        if(isset($this->_err[$method])){
            return $this->_err[$method]->setData($params);
        } else if(isset($this->_err['DEFAULT'])){
            return $this->_err['DEFAULT']->setData($params);
        } else {
            throw new Exception('Eruda_Router::run - NOT DEFAULT METHOD');
        }
    }
}

?>
