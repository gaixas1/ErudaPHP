<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Model_LogForm
 *
 * @author gaixas1
 */
class Eruda_Model_LogForm extends Eruda_Model{
    protected $username;
    protected $mantain;
    protected $error;
    protected $pass;
    protected $ref;
    
    public function __toString() {
        return 'Eruda_Model_LogForm';
    }
    
    public function get_mantain() {
        return $this->mantain;
    }
    public function get_username() {
        return $this->username;
    }
    public function get_pass() {
        return $this->pass;
    }
    public function get_error() {
        return $this->error;
    }
    
    public function set_username($val) {
        return $this->username = $val;
    }
    public function set_mantain($val) {
        return $this->mantain = $val;
    }
    public function set_pass($val) {
        return $this->pass = $val;
    }
    public function set_errors($val) {
        return $this->error = $val;
    }
    public function add_error($val) {
        return $this->error[] = $val;
    }
    
    
    public function get_errors() {
        $ret = '';
        $i = 1;
        foreach($this->error as $error){
            if($i>1) $ret.='<br/>';
            $ret .= $i.' - '.$error;
            $i++;
        }
        
        return $ret;
    }
    
    public function has_errors() {
        return $this->error!=null;
    }
    public function set_ref($val){
        $this->ref = $val;
    }
    public function get_ref(){
        return $this->ref;
    }
}

?>