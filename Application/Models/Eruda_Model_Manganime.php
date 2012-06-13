<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Model_Manganime
 *
 * @author gaixas1
 */
class Eruda_Model_Manganime extends Eruda_Model {
    protected $_user;
    protected $_series;
    protected $_downloads;
    
    function __construct($user, $series, $downloads){
        $this->_user = $user;
        $this->_series = $series;
        $this->_downloads = $downloads;
    }
    
    function get_user(){
        return $this->_user;
    }
    function get_series(){
        return $this->_series;
    }
    function get_downloads(){
        return $this->_downloads;
    }

    public function __toString() {
        return 'Eruda_Model_Manganime';
    }
}

?>
