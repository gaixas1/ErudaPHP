<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Model_Comment
 *
 * @author gaixas1
 */
class Eruda_Model_Comment extends Eruda_Model {
    protected $id;
    protected $text;
    protected $author_id;
    protected $author;
    protected $valid;
    
    protected $date;
    
    
    function set_id($id){
        $this->id = $id;
        return $this;
    }
    function get_id(){
        return $this->id;
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
    
    function set_date($date){
        $this->date = $date;
        return $this;
    }
    function get_date(){
        return $this->date;
    }
    
    function set_valid($valid){
        $this->valid = $valid;
        return $this;
    }
    function get_valid(){
        return $this->valid;
    }
    
    function is_valid(){
        return $this->valid>0;
    }
    
    function can_see($user){
        return $this->is_valid() || $user->get_id()==$this->author_id || Eruda_Helper_Auth::canAdmin($user);
    }
    
    public function __toString() {
        return 'Eruda_Model_Comment('.$this->id.')::'.$this->title;
    }
}

?>
