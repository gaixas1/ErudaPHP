<?php

/**
 * Description of Eruda_Model_Category
 *
 * @author gaixas1
 */
class Eruda_Model_Category extends Eruda_Model implements Eruda_Interface_sitemapItem {
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

    public function __toString() {
        return 'Eruda_Model_Category('.$this->id.')::'.$this->name;
    }


    public function sitemap_get_changefreg() {
        return 'monthly';
    }

    public function sitemap_get_lastmod() {}

    public function sitemap_has_lastmod() {
        return false;
    }

    public function sitemap_get_loc() {
        return Eruda::getEnvironment()->getBaseURL().Eruda_Helper_Parser::Text2Link($this->link).'/';
    }

    public function sitemap_get_priority() {
        return '0.9';
    }
    
}

?>
