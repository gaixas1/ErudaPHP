<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Validator_Equal
 *
 * @author gaixas1
 */
class Eruda_Validator_Equal extends Eruda_Validator {
    protected $field;
    protected $noEq;
    
    function __construct($field, $e=null) {
        $this->field = $field;
        $this->noEq = $e;
    }
    
    public function valid($val) {
        if(isset($_POST[$this->field]) && strlen(trim($_POST[$this->field]))>0) {
            $value = trim($_POST[$this->field]);
        } else {
            $value = null;
        }
        
        if($val == $value){
            return true;
        } else {
            if($this->noEq!=null) $this->error = $this->noEq;
            return false;
        }
    }
}

?>
