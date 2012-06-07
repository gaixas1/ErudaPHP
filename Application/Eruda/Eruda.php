<?php
/**
 * Description of Eruda_Core
 *
 * @author gaixas1
 */
/**
 * @property string $_uri
 * @property string $_base
 * @property string $_method
 * @property Eruda_Router $_router
 * @property Eruda_CF $_cf
 * @property array $_params
 * @property array(string) $_folders
 * @property array $_environment
 * @property Eruda_DBConnector $_dbcon
 */
class Eruda {
    static protected $_uri;
    static protected $_base;
    static protected $_method;
    static protected $_router;
    static protected $_cf;
    static protected $_params;
    static protected $_environment;
    static protected $_dbcon;
    
    static protected $_folders = array();
    
    /**
     * @param Eruda_Router $router 
     */
    static function init(){
        self::$_router = null;
        self::$_base = '';
        self::setUri($_SERVER['REQUEST_URI']);
        self::setMethod($_SERVER['REQUEST_METHOD']);
        
        self::$_cf = null;
        self::$_params = array();
    }
    
    
    /** 
     */
    static function parseUri() {
        if(self::$_router!=null) {
            $uri = preg_replace('~'.self::$_base.'~', '', self::$_uri, 1);
            if($uri[0]=='/') $uri = substr($uri, 1);
            self::setCF(self::$_router->run($uri, self::$_method, self::$_params));
        }
    }
    
    /**
     * @param Eruda_Router $router
     * @throws Exception 
     */
    static function setRouter($router) {
        if($router!= null && $router instanceof Eruda_Router) {
            self::$_router = $router;
        } else {
            throw new Exception('Eruda_Core::run - NOT VALID ROUTER');
        }
    }
    
    /**
     * @return Eruda_Router 
     */
    static function getRouter(){
        return self::$_router;
    }
    
    /**
     * @param string $base
     * * @throws Exception 
     */
    static function setBase($base) {
        if($base!= null && is_string($base)) {
            self::$_base = $base;
        } else {
            throw new Exception('Eruda_Core::setBase - NOT VALID BASE');
        }
    }
    
    /**
     * @return string 
     */
    static function getBase() {
        return self::$_base;
    }
    
    
    /**
     *
     * @param string $uri
     * @throws Exception 
     */
    static function setUri($uri) {
        if($uri!= null && is_string($uri)) {
            self::$_uri = $uri;
        } else {
            throw new Exception('Eruda_Core::setUri - NOT URI');
        }
    }
    
    /**
     * @return string 
     */
    static function getUri() {
        return self::$_uri;
    }
    
    /**
     *
     * @param string $method
     * @throws Exception 
     */
    static function setMethod($method) {
        if($method!= null && is_string($method) && in_array($method, Eruda_CF::$_methods)) {
            self::$_method = $method;
        } else {
            throw new Exception('Eruda_Core::setMethod - Bad Method');
        }
    }
    
    /**
     * @return string 
     */
    static function getMethod() {
        return self::$_method;
    }
    
    /**
     * @param Eruda_CF $cf
     * @throws Exception 
     */
    static function setCF($cf) {
        if($cf!=null && $cf instanceof Eruda_CF) {
            self::$_cf = $cf;
        } else {
            throw new Exception('Eruda_Core::setCF - Bad CF');
        }
    }
    
    /**
     * @return Eruda_CF 
     */
    static function getCF(){
        return self::$_cf;
    }
    
    /**
     */
    static function resetFolders(){
        self::$_folders = array();
    }
    
    /**
     * @param array(string) $folder
     * @throws Exception 
     */
    static function setFolders($folders) {
        if($folders!=null && is_array($folders)) {
			self::$_folders = $folders;
        } else {
            throw new Exception('Eruda_Core::setFolders - INVALIDS FOLDERS : '.$folders);
        }
    }
    
    /**
     * @param string $folder
     * @param string $dir
     * @throws Exception 
     */
    static function addFolder($folder, $dir) {
        if($folder!=null && is_string($folder) && strlen($folder)>0) {
            if($dir!=null && is_string($dir) && strlen($dir)>0) {
                $folder = strtolower($folder);
                self::$_folders[$folder] = $dir;
            } else {
                throw new Exception('Eruda_Core::addFolder - INVALID DIRECTORY : '.$dir);
            }
        } else {
            throw new Exception('Eruda_Core::addFolder - INVALID FOLDER : '.$folder);
        }
    }
    
    /**
     * @return array(string) 
     */
    static function getFolders(){
        return self::$_folders;
    }
    
    
    /**
     */
    static function resetEnvironment(){
        self::$_environment = array();
    }
    
    /**
     * @param array(string) $folder
     * @throws Exception 
     */
    static function setEnvironment($environment) {
        if($environment!=null && is_array($environment)) {
            self::$_environment = $environment;
        } else {
            throw new Exception('Eruda_Core::setFolders - INVALIDS FOLDERS : '.$environment);
        }
    }
    
    /**
     * @param string $folder
     * @param string $dir
     * @throws Exception 
     */
    static function addEnvironment($attr, $val) {
        if($attr!=null && is_string($attr) && strlen($attr)>0) {
            if($val!=null && is_string($val) && strlen($val)>0) {
                self::$_environment[$attr] = $val;
            } else {
                throw new Exception('Eruda_Core::addEnvironment - INVALID VALUE : '.$val);
            }
        } else {
            throw new Exception('Eruda_Core::addEnvironment - INVALID ATTRIBUTE : '.$attr);
        }
    }
    
    /**
     * @return array(string) 
     */
    static function getEnvironment(){
        return self::$_environment;
    }
    
    /**
     * @return \Eruda_DBConnector 
     */
    static function getDBConnector(){
        return self::$_dbcon;
    }
    
    /**
     * @param Eruda_DBConnector $connector
     * @throws Exception 
     */
    static function setDBConnector($connector){
        if($connector!=null && $connector instanceof Eruda_DBConnector)
            self::$_dbcon = $connector;
        else
            throw new Exception('Eruda_Core::setDBConnector - INVALID DBCONNECTOR : '.$connector);
    }
}

?>
