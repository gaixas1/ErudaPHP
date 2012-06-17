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
    protected $_avisos;
    protected $_cats;
    protected $_entry;
    protected $_comments;
    protected $_errors;
    protected $_comtxt;
    
    function __construct($user, $cats, $archives, $avisos, $entry, $comments, $errors=null, $comtxt=''){
        $this->_user = $user;
        $this->_cats = $cats;
        $this->_entry = $entry;
        $this->_archives = $archives;
        $this->_avisos = $avisos;
        $this->_comments = $comments;
        $this->_errors = $errors;
        $this->_comtxt = $comtxt;
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
    function get_entry(){
        return $this->_entry;
    }
    function get_comments(){
        return $this->_comments;
    }
    function get_comtxt(){
        return $this->_comtxt;
    }
    
    public function get_errors() {
        $ret = '';
        $i = 1;
        foreach($this->_errors as $error){
            if($i>1) $ret.='<br/>';
            $ret .= $i.' - '.$error;
            $i++;
        }
        
        return $ret;
    }
    
    public function has_errors() {
        return $this->_errors!=null;
    }
    
    
    public function __toString() {
        return 'Eruda_Model_ViewEntry';
    }
}

?>
