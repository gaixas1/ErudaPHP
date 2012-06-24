<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Environment
 *
 * @author gaixas1
 */
class Eruda_Environment {
    protected $_title;
    protected $_baseurl;
    protected $_entriesperpage;
    protected $_adminmail;
    protected $_mobile;
    
    function __construct($title, $baseurl, $entriesperpage, $adminmail){
        $this->_title = $title;
        $this->_baseurl = $baseurl;
        $this->_entriesperpage = $entriesperpage;
        $this->_adminmail = $adminmail;
        
        $device = strtolower($_SERVER['HTTP_USER_AGENT']);

        $this->_mobile = null;
        
        if(isset($_SESSION['ERUDA_DEVICE'])) {
            if($_SESSION['ERUDA_DEVICE']=='mobile')
                 $this->_mobile = true;
            else if($_SESSION['ERUDA_DEVICE']=='pc')
                 $this->_mobile = false;
        }
        if($this->_mobile===null)
            $this->_mobile =  ((stripos($device,'symbian') !== false)||(stripos($device,'windows ce') !== false)||(stripos($device,'blackberry') !== false)||(stripos($device,'palm') !== false)||(stripos($device,'android') !== false)||(stripos($ua,'mobile') !== false)||(stripos($device,'ipad') !== false)||(stripos($ua,'iphone') !== false));

    }
    
    function getTitle(){
        return $this->_title;
    }
    
    function getEntriesPerPage(){
        return $this->_entriesperpage;
    }
    
    function getBaseURL(){
        return $this->_baseurl;
    }
    
    function getMail(){
        return $this->_adminmail;
    }
    
    function isMobile(){
        return $this->_mobile;
    }
    
    function setTitle($val){
        $this->_title = $val;
    }
    
    function setEntriesPerPage($val){
        $this->_entriesperpage = $val;
    }
    
    function setBaseURL($val){
        $this->_baseurl = $val;
    }
    
    function setMail($val){
        $this->_adminmail = $val;
    }
    
    function setMobile($val = true){
        $this->_mobile = $val;
        if($val)
            $_SESSION['ERUDA_DEVICE'] = 'mobile';
        else
            $_SESSION['ERUDA_DEVICE'] = 'pc';
    }
}

?>
