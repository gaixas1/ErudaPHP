<?php

/**
 * Description of Eruda_Model_Category
 *
 * @author gaixas1
 */
class Eruda_Model_Category extends Eruda_Model {
    protected $id;
    protected $name;
    protected $link;
    protected $count;
    
    function set_id($id){
        $this->id = $id;
        return $this;
    }
    function get_id(){
        return $this->id;
    }
    
    function set_name($name){
        $this->name = $name;
        return $this;
    }
    function get_name(){
        return $this->name;
    }
    
    function set_link($link){
        $this->link = $link;
        return $this;
    }
    function get_link(){
        return $this->link;
    }
    
    function set_count($count){
        $this->count = $count;
        return $this;
    }
    function get_count(){
        return $this->count;
    }
    
}

?>
