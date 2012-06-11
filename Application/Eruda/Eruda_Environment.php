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
    
    function __construct($title, $baseurl, $entriesperpage){
        $this->_title = $title;
        $this->_baseurl = $baseurl;
        $this->_entriesperpage = $entriesperpage;
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
    
    function setTitle($val){
        $this->_title = $val;
    }
    
    function setEntriesPerPage($val){
        $this->_entriesperpage = $val;
    }
    
    function setBaseURL($val){
        $this->_baseurl = $val;
    }
}

?>
