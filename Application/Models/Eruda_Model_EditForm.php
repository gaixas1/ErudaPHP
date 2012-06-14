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
class Eruda_Model_EditForm extends Eruda_Model {
    protected $user;
    protected $passact;
    protected $passnew;
    protected $changed;
    protected $error = array();
    
    public function __construct(){
    }
    
    public function __toString() {
        return 'Eruda_Model_EditForm';
    }
    
    public function get_user() {
        return $this->user;
    }
    
    public function get_passact() {
        return $this->passact;
    }
    public function get_passnew() {
        return $this->passnew;
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
    
    
    
    public function set_changed() {
        return $this->changed = true;
    }
    public function changed() {
        return $this->changed;
    }
    
    
    public function set_user($val) {
        return $this->user = $val;
    }
    
    public function set_passact($val) {
        return $this->passact = $val;
    }
    public function set_passnew($val) {
        return $this->passnew = $val;
    }
    
    public function set_errors($val) {
        return $this->error = $val;
    }
    public function add_error($val) {
        return $this->error[] = $val;
    }
}

?>
