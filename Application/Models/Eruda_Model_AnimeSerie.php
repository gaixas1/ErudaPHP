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
class Eruda_Model_AnimeSerie extends Eruda_Model {
    protected $_id;
    protected $_serie;
    protected $_cont;
    
    function __construct($vals = array()){
        $this->_cont= array();
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
    
    function get_cont(){
        return $this->_cont;
    }
    function set_cont($val){
        $t = split(',', $val);
        foreach($t as $v){
            if($v!=null && trim($v)!=''){
                $this->_cont[] = trim($v);
            }
        }
        return $this->_cont;
    }
    
    
    function get_links(){
        $base = '/anime/'.strtolower($this->_serie).'/';
        $links = array();
        foreach($this->_cont as $cont){
            $links[] = array($base.strtolower($cont).'/', Eruda_Helper_Parser::Link2Text($cont));
        }
        return $links;
    }
    
    public function __toString() {
        return 'Eruda_Model_AnimeSerie('.$this->id.')';
    }
    
}

?>