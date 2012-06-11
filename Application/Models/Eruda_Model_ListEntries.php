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
    protected $_cats;
    protected $_entries;
    
    function __construct($user, $cats, $entries){
        $this->_user = $user;
        $this->_cats = $cats;
        $this->_entries = $entries;
    }
    
    function get_user(){
        return $this->_user;
    }
    function get_cats(){
        return $this->_cats;
    }
    function get_entries(){
        return $this->_entries;
    }
}

?>
