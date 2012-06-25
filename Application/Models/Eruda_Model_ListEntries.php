<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Model_ListEntries
 *
 * @author gaixas1
 */
class Eruda_Model_ListEntries extends Eruda_Model {
    protected $_user;
    protected $_archives;
    protected $_avisos;
    protected $_cats;
    protected $_entries;
    protected $_page;
    protected $_title;
    
    function __construct($user, $cats, $archives, $avisos, $entries, $page, $title=null){
        $this->_user = $user;
        $this->_cats = $cats;
        $this->_entries = $entries;
        $this->_archives = $archives;
        $this->_avisos = $avisos;
        $this->_page = $page;
        $this->_title = $title;
    }
    
    function get_user(){
        return $this->_user;
    }
    function get_cats(){
        return $this->_cats;
    }
    function get_archives(){
        return $this->_archives;
    }
    function get_avisos(){
        return $this->_avisos;
    }
    function get_entries(){
        return $this->_entries;
    }
    function get_page(){
        return $this->_page;
    }
    function get_title(){
        return $this->_title;
    }
    
    
    public function __toString() {
        return 'Eruda_Model_ListEntries';
    }
}

?>