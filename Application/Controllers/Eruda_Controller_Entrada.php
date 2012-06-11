<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Controller_Entry
 *
 * @author gaixas1
 */
class Eruda_Controller_Entrada extends Eruda_Controller{
    protected $cats;
    protected $user;
    
    public function end() {
        Eruda::getDBConnector()->connect();
        
        $this->user = Eruda_Helper_Auth::getUser();
        
        if(!$this->_onlyheader) {
            $this->cats = Eruda_Mapper_Category::All();
        }
    }
    
    public function ini() {
        Eruda::getDBConnector()->disconnect();
    }
    
    function index() {
        if(!$this->_onlyheader) {
            
        }
    }
}

?>
