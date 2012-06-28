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
 * @property Eruda_Environment $_environment
 * @property Eruda_DBConnector $_dbcon
 * @property Eruda_MV $_mv
 */
class Eruda {
    static protected $_uri;
    static protected $_base;
    static protected $_method;
    static protected $_router;
    static protected $_cf;
    static protected $_mailer;
    static protected $_params;
    static protected $_environment;
    static protected $_dbcon = array();
    static protected $_mv;
    
    static protected $_folders = array();
    
    /**
     * @param Eruda_Router $router 
     */
    static function init(){
        self::$_router = null;
        self::$_base = '';
        $url = explode('?',$_SERVER['REQUEST_URI']);
        self::setUri($url[0]);
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
     * @param Eruda_Environment $environment
     * @throws Exception 
     */
    static function setEnvironment($environment) {
        if($environment!=null && $environment instanceof Eruda_Environment) {
            self::$_environment = $environment;
        } else {
            throw new Exception('Eruda_Core::setEnvironment - INVALIDS ENVIRONMENT : '.$environment);
        }
    }
    
    /**
     * @return \Eruda_Environment
     */
    static function getEnvironment(){
        return self::$_environment;
    }
    
    /**
     * @return \Eruda_DBConnector 
     */
    static function getDBConnector($i = 0){
        return self::$_dbcon[$i];
    }
    
    /**
     * @param Eruda_DBConnector $connector
     * @throws Exception 
     */
    static function setDBConnector($connector){
        if($connector!=null && $connector instanceof Eruda_DBConnector)
            self::$_dbcon[] = $connector;
        else
            throw new Exception('Eruda_Core::setDBConnector - INVALID DBCONNECTOR : '.$connector);
    }
    
    
    /**
     * @return Eruda_Mailer
     */
    static function getMailer(){
        return self::$_mailer;
    }
    
    /**
     * @param Eruda_DBConnector $connector
     * @throws Exception 
     */
    static function setMailer($mailer){
        if($mailer!=null && $mailer instanceof Eruda_Mailer)
            self::$_mailer = $mailer;
        else
            throw new Exception('Eruda_Core::setMailer - INVALID Mailer : '.$mailer);
    }
    
    
    static function runController(){
        $temp = self::$_cf;
        $i=0;
        do {
            try {
                $controller_name = 'Eruda_Controller_'.$temp->getController();
                $function_name =$temp->getFunction();

                $controller = new $controller_name(self::$_params, self::$_method=='HEADER');
                $controller->ini();
                $temp = $controller->$function_name();
                $controller->end();
                $i++;
            } catch (Exception $e) {
                $controller = new Eruda_Controller_Error(null, self::$_method=='HEADER');
                $controller->ini();
                $temp = $controller->E500();
                $controller->end();
            }
        }while(($temp instanceof Eruda_CF) && $i<5);
        
        if($i>=5){
            $controller = new Eruda_Controller_Error(null, self::$_method=='HEADER');
            $controller->ini();
            $temp = $controller->E500();
            $controller->end();
        }
        self::$_mv = $temp;
    }
    
    
    static function runCron($fun = 'Index'){
        $controller = new Eruda_Cron();
        try {
            $controller->ini();
            $controller->$fun();
            $controller->end();
        } catch (Exception $e) {
            $controller->log('Error '.print_r(e,true));
        }
    }
    
    static function show(){
        self::$_mv->show();
    }
}

?>
