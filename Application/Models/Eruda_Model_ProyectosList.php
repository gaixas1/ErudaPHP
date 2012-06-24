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
class Eruda_Model_ProyectosList extends Eruda_Model {
    protected $_user;
    protected $_proyectos;
    protected $_items;
    protected $_avisos;
    
    function __construct($user, $avisos, $proyectos, $items){
        $this->_user = $user;
        $this->_avisos = $avisos;
        $this->_proyectos = $proyectos;
        $this->_items = $items;
    }
    
    function get_user(){
        return $this->_user;
    }
    function get_avisos(){
        return $this->_avisos;
    }
    function get_proyectos(){
        return $this->_proyectos;
    }
    function get_items(){
        return $this->_items;
    }

    public function __toString() {
        return 'ProyectosList';
    }
}

?>
