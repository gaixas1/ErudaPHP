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
    protected $error;
    
    public function __construct($username, $error = null){
        $this->username = $username;
        $this->error = $error;
    }
    
    public function __toString() {
        return 'Eruda_Model_LogForm';
    }
    
    public function get_username() {
        return $this->username;
    }
    public function get_error() {
        return $this->error;
    }
}

?>
