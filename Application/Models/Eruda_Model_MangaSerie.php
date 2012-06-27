<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Model_MangaSerie
 *
 * @author gaixas1
 */
class Eruda_Model_MangaSerie extends Eruda_Model {
    protected $_id;
    protected $_serie;
    protected $_tomos;
    
    function __construct($vals = array()){
        $this->_tomos= array();
        parent::__construct($vals);
        }


    function get_id(){
        return $this->_id;
    }
    function set_id($val){
        return $this->_id = $val;
    }
    
    function get_serie(){
        return $this->_serie;
    }
    function set_serie($val){
        return $this->_serie = $val;
    }
    
    function get_tomos(){
        return $this->_tomos;
    }
    function set_tomos($val){
        $t = split(',', $val);
        foreach($t as $v){
            if($v!=null && trim($v)!=''){
                $this->_tomos[] = trim($v);
            }
        }
        return $this->_tomos;
    }
    
    
    function get_links(){
        $base = '/manga/'.strtolower($this->_serie).'/';
        $links = array();
        
        if($this->_serie!='One_Shots')
            foreach($this->_tomos as $tomo){
                $links[] = array($base.strtolower($tomo).'/', 'Tomo '.Eruda_Helper_Parser::Link2Text($tomo));
            }
        else
            foreach($this->_tomos as $tomo){
                $links[] = array($base.strtolower($tomo).'/', Eruda_Helper_Parser::Link2Text($tomo));
            }
        return $links;
    }
    
    public function __toString() {
        return 'Eruda_Model_MangaSerie('.$this->id.')';
    }
    
}

?>