<?php
/**
 * Description of Eruda_Field
 *
 * @author gaixas1
 */
class Eruda_Field_Array extends Eruda_Field {
    function validate(){
        $this->value = array();
        if(isset($_POST[$this->form_field]) && is_array($_POST[$this->form_field]) && count($_POST[$this->form_field])>0){
            foreach($_POST[$this->form_field] as $field){
                if(strlen(trim($field))>0) {
                    $this->value[] = $field;
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
