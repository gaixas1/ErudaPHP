<?php
/**
 * Description of Eruda_Model_Entry
 *
 * @author gaixas1
 */

class Eruda_Model_Entry extends Eruda_Model {
    protected $id;
    protected $title;
    protected $text;
    protected $comments;
    
    protected $created;
    protected $lastmod;
    
    protected $author_id;
    protected $author;
    
    protected $cats_id = array();
    protected $cats = array();
    
    //
    //protected $tags = array();
    
    function set_id($id){
        $this->id = $id;
        return $this;
    }
    function get_id(){
        return $this->id;
    }
    
    
    function set_title($title){
        $this->title = $title;
        return $this;
    }
    function get_title(){
        return $this->title;
    }
    
    function set_text($text){
        $this->text = $text;
        return $this;
    }
    function get_text(){
        return $this->text;
    }
    
    function set_author_id($author_id){
        $this->author_id = $author_id;
        return $this;
    }
    function get_author_id(){
        return $this->author_id;
    }
    
    function set_author($author){
        $this->author = $author;
        return $this;
    }
    function get_author(){
        return $this->author;
    }
    
    
    function set_cats_id($cats_id){
        $this->cats_id = $cats_id;
        return $this;
    }
    function get_cats_id(){
        return $this->cats_id;
    }
    
    function set_cats($cats){
        $this->cats = $cats;
        return $this;
    }
    function get_cats(){
        return $this->cats;
    }
    
    function set_comments($comments){
        $this->comments = $comments;
        return $this;
    }
    function get_comments(){
        return $this->comments;
    }
    /*
    function set_tags($tags){
        $this->tags = $tags;
        return $this;
    }
    function get_tags(){
        return $this->tags;
    }
    */
    function set_created($created){
        $this->created = $created;
        return $this;
    }
    function get_created(){
        return $this->created;
    }
    
    function set_lastmod($lastmod){
        $this->lastmod = $lastmod;
        return $this;
    }
    function get_lastmod(){
        return $this->lastmod;
    }
    

    public function __toString() {
        return 'Eruda_Model_Entry('.$this->id.')::'.$this->title;
    }
}

?>
