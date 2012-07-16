<?php
/**
 * Description of eRouter
 * Eruda Router
 * URI+Method > eCF
 *
 * @author gaixas1
 */
class eRouter {
    public static $methods = array('DEFAULT'=>0, 'GET'=>1, 'POST'=>2, 'PUT'=>3, 'DELETE'=>4, 'HEAD'=>5);
    
    protected $def;
    protected $ext;
    
    function __construct() {
        $this->def = array();
        $this->ext = array();
    }
    
    function run($uri, $method, &$params) {
        if(isset(self::$methods[$method])){
            $mt = self::$methods[$method]; 
        } else {
            $mt = 0;
        }   
        
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
            if(isset($this->def[$mt])){
                return $this->def[$mt];
            } else if(isset($this->def[0])){
                return $this->def[0];
            }
        }
        throw new Exception('Eruda_Router::run - NOT DEFAULT METHOD');
    }
    
    function addCF($cf, $method='DEFAULT') {
        if(isset(self::$methods[$method])){
            $mt = self::$methods[$method]; 
        } else {
            $mt = 0;
        }
        $this->def[$mt] = $cf;
        return $this;
    }
    
    function addRouter($key, $router) {
        $this->ext[$key] = $router;
        return $this;
    }
    
    static function parse($router){
        $file = trim(file_get_contents ($router));
        return self::parseR(json_decode($file));
    }
    
    static private function parseR($array){
        $router = new eRouter();
        if(isset($array->C)){
            self::parseC($array->C, $router);
        }
        if(isset($array->S)){
            self::parseS($array->S, $router);
        }
        return $router;
    }
    
    static private function parseC($array, &$router){
        foreach($array as $cf){
            $n = new eCF();
            if(isset($cf->ctr))
                $n->setController ($cf->ctr);
            if(isset($cf->fn))
                $n->setFunction ($cf->fn);
            if(isset($cf->mth))
                $router->addCF($n,$cf->mth);
            else
                $router->addCF($n);
        }
    }
    
    static private function parseS($array, &$router){
        foreach($array as $k => $vl){
            $rt = self::parseR($vl);
            $router->addRouter($k,$rt);
        }
    }
}

?>