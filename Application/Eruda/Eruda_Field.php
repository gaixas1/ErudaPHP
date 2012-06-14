<?php
/**
 * Description of Eruda_Field
 *
 * @author gaixas1
 */
class Eruda_Field {
    protected $form_field;
    protected $value;
    protected $error;
    protected $validators;
    protected $required;
    
    function __construct($form_field, $required = null){
        $this->form_field = $form_field;
        $this->validators = array();
        $this->required = $required;
    }
    
    function add_validator($validator){
        $this->validators[] = $validator;
        return $this;
    }
    
    function validate(){
        if(isset($_POST[$this->form_field]) && strlen(trim($_POST[$this->form_field]))>0) {
            $this->value = trim($_POST[$this->form_field]);
            foreach ($this->validators as $validator) {
                if(!$validator->valid($this->value)) {
                    $this->error = $validator->get_error();
                    return false;
                }
            }
            return true;
        } else {
            $this->value = null;
            if($this->required!=null){
                $this->error = $this->required;
                return false;
            } else
                return true;
        }
    }
    
    function get_error(){
        return $this->error;
    }
    
    function get_value(){
        return $this->value;
    }
}

?>
