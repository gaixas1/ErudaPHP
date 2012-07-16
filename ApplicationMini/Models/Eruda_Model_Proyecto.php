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
class Eruda_Model_Proyecto extends Eruda_Model implements Eruda_Interface_sitemapItem {
    protected $_id;
    protected $_serie;
    protected $_tipo;
    protected $_estado;
    protected $_texto;
    
    function __construct($vals = array()){
        $this->_id = 0;
        $this->_serie = '';
        $this->_tipo = '';
        $this->_estado = '';
        $this->_texto = '********* Texto *********
		
Traducción :: *********
Edición :: *********';
        
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
    
    function get_tipo(){
        return $this->_tipo;
    }
    function set_tipo($val){
        return $this->_tipo = $val;
    }
    
    function get_estado(){
        return $this->_estado;
    }
    function set_estado($val){
        return $this->_estado = $val;
    }
    
    function get_texto(){
        return $this->_texto;
    }
    function set_texto($val){
        return $this->_texto = $val;
    }
    
    
    public function __toString() {
        return 'Eruda_Model_Proyecto('.$this->id.')';
    }


    public function sitemap_get_changefreg() {
        return 'yearly';
    }

    public function sitemap_get_lastmod() {}

    public function sitemap_has_lastmod() {
        return false;
    }

    public function sitemap_get_loc() {
        return Eruda_Environment::getBaseURL().'proyectos/'.$this->_id.'/'.Eruda_Helper_Parser::Text2Link($this->serie).'/';
    }

    public function sitemap_get_priority() {
        return '0.5';
    }
    
}

?>