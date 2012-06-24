<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Controller_Config
 *
 * @author gaixas1
 */
class Eruda_Controller_Config extends Eruda_Controller {
    protected $refered;
    
    public function end() {
        
    }
    public function ini() {
        if(isset($_SERVER['HTTP_REFERER']) && strlen($_SERVER['HTTP_REFERER'])>0){
            $this->refered = $_SERVER['HTTP_REFERER'];
        } else {
            $this->refered = Eruda::getEnvironment()->getBaseURL();
        }
    }
    
    public function Change2Mobile(){
        Eruda::getEnvironment()->setMobile(true);
        header( 'Location: '.$this->refered ) ;
        $this->end();exit();
    }
    public function Change2PC(){
        Eruda::getEnvironment()->setMobile(false);
        header( 'Location: '.$this->refered ) ;
        $this->end();exit();
    }
}

?>
