<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Model_Aviso
 *
 * @author gaixas1
 */
class Eruda_Model_Aviso extends Eruda_Model {
    protected $id;
    protected $msg;
    
    function set_id($id){
        $this->id = $id;
        return $this;
    }
    function get_id(){
        return $this->id;
    }
    function set_msg($msg){
        $this->msg = $msg;
        return $this;
    }
    function get_msg(){
        return $this->msg;
    }
    
    public function __toString() {
        return 'Eruda_Model_Aviso('.$this->id.')::'.$this->msg;
    }
}

?>
