<?php
/**
 * Description of eCore
 * Eruda Framework Core
 * STATIC CLASS
 *
 * @author gaixas1
 */
class eCore {
    static protected $uri;
    static protected $base;
    static protected $method;
    static protected $router;
    static protected $cf;
    static protected $mailer;
    static protected $params;
    static protected $dbcon = array();
    static protected $mv;
    
    static protected $folders = array();
    
    static function init(){
        self::$router = null;
        self::$base = '';
        $url = explode('?',$_SERVER['REQUEST_URI']);
        self::$uri = $url[0];
        self::$method = $_SERVER['REQUEST_METHOD'];
        
        self::$cf = null;
        self::$params = array();
        self::$numCFchange = 5;
    }
    
    static function parseUri() {
        if(self::$router!=null) {
            $uri = preg_replace('~'.self::$base.'~', '', self::$uri, 1);
            if($uri[0]=='/') $uri = substr($uri, 1);
            self::setCF(self::$router->run($uri, self::$method, self::$params));
        }
    }
    
    static function runController(){
        $temp = self::$cf;
        $i=0;
        do {
            try {
                $ctrl_name = 'eController_'.$temp->getController();
                $fn_name =$temp->getFunction();

                $ctrl = new $ctrl_name(self::$params, self::$method=='HEADER');
                $ctrl->ini();
                $temp = $ctrl->$fn_name();
                $ctrl->end();
                $i++;
            } catch (Exception $e) {
                $ctrl = new eController_Error(null, self::$method=='HEADER');
                $ctrl->ini();
                $temp = $ctrl->E500();
                $ctrl->end();
            }
        }while(($temp instanceof eCF) && $i<self::$numCFchange);
        
        if($i>=5){
            $ctrl = new eController_Error(null, self::$method=='HEADER');
            $ctrl->ini();
            $temp = $ctrl->E500();
            $ctrl->end();
        }
        self::$mv = $temp;
    }
    
    
    static function runCron($fun = 'Index'){
        $ctrl = new eCron();
        try {
            $ctrl->ini();
            $ctrl->$fun();
            $ctrl->end();
        } catch (Exception $e) {
            $ctrl->log('Error '.print_r(e,true));
        }
    }
    
    static function show(){
        self::$mv->show();
    }
    
/**
* * Getters & Setters
**/
    
    static function setRouter($router) {
        self::$router = $router;
    }
    
    static function getRouter(){
        return self::$router;
    }
    
    static function setBase($base) {
        self::$base = $base;
    }
    
    static function getBase() {
        return self::$base;
    }
    
    static function setUri($uri) {
        self::$uri = $uri;
    }
    
    static function getUri() {
        return self::$uri;
    }
    
    static function setMethod($method) {
        self::$method = $method;
    }
    
    static function getMethod() {
        return self::$method;
    }
    
    static function setCF($cf) {
        self::$cf = $cf;
    }
    
    static function getCF(){
        return self::$cf;
    }
    
    static function resetFolders(){
        self::$folders = array();
    }
    
    static function setFolders($folders) {
        self::$folders = $folders;
    }
    
    static function addFolder($folder, $dir) {
        $folder = strtolower($folder);
        self::$folders[$folder] = $dir;
    }
    
    static function getFolders(){
        return self::$folders;
    }
    
    static function getDBConnector($i = 0){
        return self::$dbcon[$i];
    }
    
    static function setDBConnector($connector, $i=null){
        if($i!=null)
            self::$dbcon[$i] = $connector;
        else
            self::$dbcon[] = $connector;
    }
    
    static function getMailer(){
        return self::$mailer;
    }
    static function setMailer($mailer){
        self::$mailer = $mailer;
    }
}
?>