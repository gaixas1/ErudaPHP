<?php
/**
 * Description of eModel => Error
 * Eruda Error Model
 * AppModel for error pages
 *
 * @author gaixas1
 */
class eModel_Error extends eModel {
    protected $url;
    protected $message;
    protected $extra;
    
    
    function set_url($val){
        $this->url = $val;
    }
    function set_message($val){
        $this->message = $val;
    }
    function set_extra($val){
        $this->extra = $val;
    }
    
    function get_url(){
        return $this->url;
    }
    
    function get_message(){
        return $this->message;
    }
    
    function get_extra(){
        return $this->extra;
    }
    

    public function __toString() {
        return 'eModel_Error::'.$this->message;
    }
}
?>