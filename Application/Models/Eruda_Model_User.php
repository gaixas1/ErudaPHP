<?php
/**
 * Description of Eruda_Model_User
 *
 * @author gaixas1
 */
class Eruda_Model_User extends Eruda_Model {
    protected $id;
    protected $name;
    protected $pass;
    protected $mail;
    protected $level;
    protected $registered;
    protected $last_log;
    
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
    
    function set_pass($pass){
        $this->pass = $pass;
        return $this;
    }
    function get_pass(){
        return $this->pass;
    }
    
    function set_mail($mail){
        $this->mail = $mail;
        return $this;
    }
    function get_mail(){
        return $this->mail;
    }
    
    function set_level($level){
        $this->level = $level;
        return $this;
    }
    function get_level(){
        return $this->level;
    }
    
    function set_registered($registered){
        $this->registered = $registered;
        return $this;
    }
    function get_registered(){
        return $this->registered;
    }
    
    function set_last_log($last_log){
        $this->last_log = $last_log;
        return $this;
    }
    function get_last_log(){
        return $this->last_log;
    }
    
    
}

?>
