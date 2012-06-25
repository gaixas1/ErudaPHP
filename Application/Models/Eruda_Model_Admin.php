<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Model_Admin
 *
 * @author gaixas1
 */
class Eruda_Model_Admin extends Eruda_Model {
    protected $user;
    protected $dir;
    
    public function __construct($user, $dir) {
        $this->user = $user;
        $this->dir = $dir;
    }


    public function __toString() {
        return 'Eruda_Model_Admin';
    }
    
    
    function get_user(){
        return $this->user;
    }
    
    function get_dir(){
        return $this->dir;
    }
}

?>
