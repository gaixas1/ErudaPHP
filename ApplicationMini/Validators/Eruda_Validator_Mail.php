<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Validator_Mail
 *
 * @author gaixas1
 */
class Eruda_Validator_Mail extends Eruda_Validator {
    protected $noMail;
    
    function __construct($e=null) {
        $this->noMail = $e;
    }
    
    public function valid($val) {
        if(preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $val)){
            return true;
        } else {
            if($this->noMail!=null) $this->error = $this->noMail;
            return false;
        }
    }
}


?>
