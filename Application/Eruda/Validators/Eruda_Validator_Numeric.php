<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Validator_Numeric
 *
 * @author gaixas1
 */
class Eruda_Validator_Numeric extends Eruda_Validator {
    protected $noNum;
    
    function __construct($e=null) {
        $this->noNum = $e;
    }
    
    public function valid($val) {
        if(is_numeric($val)){
            return true;
        } else {
            if($this->noNum!=null) $this->error = $this->noNum;
            return false;
        }
    }
}

?>
