<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Model_ViewEntry
 *
 * @author gaixas1
 */
class Eruda_Model_ViewEntry extends Eruda_Model {
    protected $_user;
    protected $_archives;
    protected $_cats;
    protected $_entry;
    protected $_comments;
    
    function __construct($user, $cats, $archives, $entry, $comments){
        $this->_user = $user;
        $this->_cats = $cats;
        $this->_entry = $entry;
        $this->_archives = $archives;
        $this->_comments = $comments;
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
    function get_entry(){
        return $this->_entry;
    }
    function get_comments(){
        return $this->_comments;
    }
    
    
    public function __toString() {
        return 'Eruda_Model_ViewEntry';
    }
}

?>
