<?php
/**
 * Description of eField
 * Eruda Form Field
 * Validates and get value from array field
 *
 * @author gaixas1
 */
class eField {
    protected $ff;
    protected $val;
    protected $err;
    protected $valids;
    protected $req;
    
    function __construct($ff, $req = null){
        $this->ff = $ff;
        $this->valids = array();
        $this->req = $req;
    }
    
    function add_validator($val){
        $this->valids[] = $val;
        return $this;
    }
    function validate($from = null){
        if($from == null) {
            $from = $_POST;
        }
        if(isset($from[$this->ff]) && strlen(trim($from[$this->ff]))>0) {
            $this->val = trim($from[$this->ff]);
            foreach ($this->valids as $valid) {
                if(!$valid->valid($this->val)) {
                    $this->err = $valid->get_error();
                    return false;
                }
            }
            return true;
        } else {
            $this->val = null;
            if($this->req!=null){
                $this->err = $this->req;
                return false;
            } else
                return true;
        }
    }
    
    function get_error(){
        return $this->err;
    }
    
    function get_value(){
        return $this->val;
    }
}
?>