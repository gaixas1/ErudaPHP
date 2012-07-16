<?php
class Eruda_Environment {
    static protected $_title;
    static protected $_baseurl;
    static protected $_entriesperpage;
    static protected $_adminmail;
    static protected $_mobile;
    
    static function init($title, $baseurl, $entriesperpage, $adminmail){
        self::$_title = $title;
        self::$_baseurl = $baseurl;
        self::$_entriesperpage = $entriesperpage;
        self::$_adminmail = $adminmail;
        
        $device = strtolower($_SERVER['HTTP_USER_AGENT']);

        self::$_mobile = null;
        
        if(isset($_SESSION['ERUDA_DEVICE'])) {
            if($_SESSION['ERUDA_DEVICE']=='mobile')
                 self::$_mobile = true;
            else if($_SESSION['ERUDA_DEVICE']=='pc')
                 self::$_mobile = false;
        }
        if(self::$_mobile===null)
            self::setMobile((stripos($device,'symbian') !== false)||(stripos($device,'windows ce') !== false)||(stripos($device,'blackberry') !== false)||(stripos($device,'palm') !== false)||(stripos($device,'android') !== false)||(stripos($device,'mobile') !== false)||(stripos($device,'ipad') !== false)||(stripos($device,'iphone') !== false));

    }
    
    static function getTitle(){
        return self::$_title;
    }
    
    static function getEntriesPerPage(){
        return self::$_entriesperpage;
    }
    
    static function getBaseURL(){
        return self::$_baseurl;
    }
    
    static function getMail(){
        return self::$_adminmail;
    }
    
    static function isMobile(){
        return self::$_mobile;
    }
    
    static function setTitle($val){
        self::$_title = $val;
    }
    
    static function setEntriesPerPage($val){
        self::$_entriesperpage = $val;
    }
    
    static function setBaseURL($val){
        self::$_baseurl = $val;
    }
    
    static function setMail($val){
        self::$_adminmail = $val;
    }
    
    static function setMobile($val = true){
        self::$_mobile = $val;
        if($val)
            $_SESSION['ERUDA_DEVICE'] = 'mobile';
        else
            $_SESSION['ERUDA_DEVICE'] = 'pc';
    }
}

?>
