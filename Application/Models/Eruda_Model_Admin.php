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
    protected $data;
    
    public function __construct($user, $dir, $data = array()) {
        $this->user = $user;
        $this->dir = $dir;
        $this->data = $data;
    }


    public function __toString() {
        return 'Eruda_Model_Admin';
    }
    
    function add_data($name, $val) {
        $this->data[$name] = $val;
    }
    
    function set_data($val) {
        $this->data = $val;
    }
    
    
    function get_user(){
        return $this->user;
    }
    
    function get_dir(){
        return $this->dir;
    }
    function get_data($name){
        return $this->data[$name];
    }
}

?>
