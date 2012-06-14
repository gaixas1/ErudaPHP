<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Validator_Lenght
 *
 * @author gaixas1
 */
class Eruda_Validator_Lenght extends Eruda_Validator {
    protected $min;
    protected $max;
    protected $minE;
    protected $maxE;
    
    function __construct($min, $max, $minE = null, $maxE = null) {
        $this->min = $min;
        $this->max = $max;
        $this->minE = $minE;
        $this->maxE = $maxE;
    }
    
    public function valid($val) {
        if($this->min!=null)
            if(strlen($val)<$this->min) {
                if($this->minE!=null) $this->error = $this->minE;
                return false;
            }
        if($this->max!=null)
            if(strlen($val)>$this->max) {
                if($this->maxE!=null) $this->error = $this->maxE;
                return false;
            }
        return true;
    }
}

?>
