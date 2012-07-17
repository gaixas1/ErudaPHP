<?php
/**
 * Description of eField => Array
 * Eruda Form Field, Array
 * 
 * Extension of eField:
 *  return an array of values
 *
 * @author gaixas1
 */
class eField_Array extends eField {
    function validate($from = null){
        if($from == null) {
            $from = $_POST;
        }
        $this->value = array();
        if(isset($from[$this->form_field]) && is_array($from[$this->form_field]) && count($from[$this->form_field])>0){
            foreach($_POST[$this->form_field] as $k => $field){
                if(strlen(trim($field))>0) {
                    $this->value[$k] = $field;
                    foreach ($this->validators as $validator) {
                        if(!$validator->valid($field)) {
                            $this->error = $validator->get_error();
                            break;
                        }
                    }
                }
            }
        }
        return count($this->error)==0;
    }
}

?>
