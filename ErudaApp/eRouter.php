<?php
/**
 * Description of eRouter
 * Eruda Router
 * URI+Method > eCF
 *
 * @author gaixas1
 */
class eRouter {
    protected $def = array();
    protected $err = array();
    protected $ext = array();
    
    function __construct($def = null, $ext = array(), $err = null) {
        if($def!=null) {
            if($def instanceof eCF) {
                $this->addDef($def);
            } else if (is_array($def)){
                foreach ($def as $cf) {
                    $this->addDef($cf);
                }
            }
        } 
        if(count($this->def)==0){
            $this->addDef(new eCF());
        }
        
        if($err!=null) {
            if($err instanceof eCF) {
                $this->addErr($err);
            } else if (is_array($err)){
                foreach ($err as $cf) {
                    $this->addErr($cf);
                }
            }
        } 
        if(count($this->err)==0){
            $this->addErr(new eCF('Error', 'E404'));
        }
        
        if (is_array($ext)){
            foreach ($ext as $key => $router) {
                $this->addRouter($key,$router);
            }
        } 
    }
    
    
    
    function run($uri, $method, &$params) {
        if(is_string($uri) && strlen($uri)>0) {
            foreach ($this->ext as $key => $router) {
                if(preg_match('~^'.$key.'.*$~', $uri, $matches)) {
                    array_shift($matches); 
                    foreach ($matches as $value) {
                        $params[] = $value;
                    }
                    $uri = preg_replace ('~^'.$key.'~', '', $uri);
                    return $router->run($uri, $method, $params);
                }
            }
        } else {
            if(isset($this->def[$method])){
                return $this->def[$method]->setData($params);
            } else if(isset($this->def['DEFAULT'])){
                return $this->def['DEFAULT']->setData($params);
            }
        }
        if(isset($this->err[$method])){
            return $this->err[$method]->setData($params);
        } else if(isset($this->err['DEFAULT'])){
            return $this->err['DEFAULT']->setData($params);
        } else {
            throw new Exception('Eruda_Router::run - NOT DEFAULT METHOD');
        }
    }
    
    function addDef($cf) {
        if($cf!=null && $cf instanceof Eruda_CF) {
            $this->def[$cf->getMethod()] = $cf;
        }
        return $this;
    }
    
    function addErr($cf) {
        if($cf!=null && $cf instanceof Eruda_CF) {
            $this->err[$cf->getMethod()] = $cf;
        }
        return $this;
    }
    
    function addRouter($key, $router) {
        if($key!=null && is_string($key) && strlen($key)>0 && $router!=null && $router instanceof Eruda_Router) {
            $this->ext[$key] = $router;
        }
        return $this;
    }
}

?>
