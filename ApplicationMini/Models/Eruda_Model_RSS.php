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
class Eruda_Model_RSS extends Eruda_Model {
    protected $title;
    protected $link;
    protected $language;
    protected $description;
    protected $generator;
    protected $items;
    
    public function __construct($title,$link,$language,$description,$generator,$items) {
        $this->title = $title;
        $this->link = $link;
        $this->language = $language;
        $this->description = $description;
        $this->generator = $generator;
        $this->items = $items;
    }
    
    function get_title(){
        return $this->title;
    }
    function get_link(){
        return $this->link;
    }
    function get_language(){
        return $this->language;
    }
    function get_description(){
        return $this->description;
    }
    function get_generator(){
        return $this->generator;
    }
    function get_items(){
        return $this->items;
    }

    public function __toString() {
        return 'Eruda_Model_RSS';
    }
}

?>
