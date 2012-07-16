<?php
/**
 * Description of eForm
 * Eruda Form
 * Validates and get value from array
 *
 * @author gaixas1
 */
class eForm {
    protected $return;
    protected $errors;
    protected $fields;
    protected $from;
    
    function __construct($object=null, $from = null) {
        if($from == null) {
            $this->from = $_POST;
        }
        if($object!=null) {
            $object = 'eModel_'.$object;
            $this->return = new $object();
        } else {
            $this->return = array();
        }
        $this->errors = array();
        $this->fields = array();
    }
    
    function addField($key, $field){
        $this->fields[$key] = $field;
        return $this;
    }
    
    function validate(){
        $valid = true;
        foreach ($this->fields as $field) {
            if(!$field->validate($this->from)){
                $valid = false;
                    $this->errors[] = $field->get_error();
            }
        }
        
        if($this->return instanceof eModel) {
            foreach ($this->fields as $key => $field) {
                $this->return->__set($key, $field->get_value());
            }
        } else {
            foreach ($this->fields as $key => $field) {
                $this->return[$key]= $field->get_value();
            }
        }
        
        return $valid;
    }
    
    function getValue(){
        return $this->return;
    }
    
    function getErrors(){
        return $this->errors;
    }
}
?>