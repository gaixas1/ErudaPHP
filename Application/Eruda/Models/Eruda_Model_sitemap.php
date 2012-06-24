<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Model_RSS
 *
 * @author gaixas1
 */
class Eruda_Model_sitemap extends Eruda_Model {
    protected $items;
    
    public function __construct() {
        $this->items = array();
    }
    
    function add_items($items){
        $this->items = array_merge($this->items, $items);
    }
    function add_item($item){
        $this->items[] = $item;
    }
    
    function get_items(){
        return $this->items;
    }

    public function __toString() {
        return 'Eruda_Model_sitemap';
    }
}

?>
