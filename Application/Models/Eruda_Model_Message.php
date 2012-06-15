<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Model_Message
 *
 * @author gaixas1
 */
class Eruda_Model_Message extends Eruda_Model{
    protected $msg;
    protected $ref;
    
    public function __construct($msg) {
        $this->msg = $msg;
    }


    public function __toString() {
        return $this->msg;
    }
    
    public function set_ref($val){
        $this->ref = $val;
    }
    public function get_ref(){
        return $this->ref;
    }
}

?>
