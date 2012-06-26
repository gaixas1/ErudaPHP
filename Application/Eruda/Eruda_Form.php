<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Form
 *
 * @author gaixas1
 */
class Eruda_Form {
    protected $return;
    protected $errors;
    protected $fields;
    
    function __construct($object=null) {
        if($object!=null) {
            $object = 'Eruda_Model_'.$object;
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
            if(!$field->validate()){
                $valid = false;
                    $this->errors[] = $field->get_error();
            }
        }
        
        if($this->return instanceof Eruda_Model) {
            foreach ($this->fields as $key => $field) {
                $this->return->__set($key, $field->get_value());
            }
        } else if(is_array( $this->return)) {
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