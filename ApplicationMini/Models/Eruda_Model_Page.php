<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Model_Page
 *
 * @author gaixas1
 */
class Eruda_Model_Page extends Eruda_Model{
    protected $base;
    protected $act;
    protected $max;
    
    function __construct($base, $act, $max) {
        $this->base = $base;
        $this->act = $act;
        $this->max = $max;
    }
    
    public function __toString() {
        return 'Eruda_Model_Page';
    }
    
    function get_base(){
        return $this->base;
    }
    function get_next(){
        if($this->act < $this->max)
            return $this->act+1;
        else
            return 0;
    }
    function get_prev(){
        if($this->act > 0)
            return $this->act-1;
        else
            return 0;
    }
}

?>