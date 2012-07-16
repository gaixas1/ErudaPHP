<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Model_Error
 *
 * @author gaixas1
 */
class Eruda_Model_Error extends Eruda_Model {
    protected $url;
    protected $message;
    protected $extra;
    
    
    function set_url($val){
        $this->url = $val;
    }
    function set_message($val){
        $this->message = $val;
    }
    function set_extra($val){
        $this->extra = $val;
    }
    
    function get_url(){
        return $this->url;
    }
    
    function get_message(){
        return $this->message;
    }
    
    function get_extra(){
        return $this->extra;
    }
    

    public function __toString() {
        return 'Eruda_Model_Error::'.$this->message;
    }
}

?>