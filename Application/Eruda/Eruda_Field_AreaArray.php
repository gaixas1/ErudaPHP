<?php
/**
 * Description of Eruda_Field
 *
 * @author gaixas1
 */
class Eruda_Field_AreaArray extends Eruda_Field {
    function validate(){
        $this->value = array();
        if(isset($_POST[$this->form_field]) && strlen($_POST[$this->form_field])>0){
            $lines = explode('
', $_POST[$this->form_field]);
            foreach($lines as $line){
                if(strlen(trim($line))>0) {
                    $vals = array();
                    $vars =  explode(',', $line);
                    foreach ($vars as $var) {
                        $var = trim($var);
                        if(strlen($var)>0){
                            $vals[] = $var;
                            foreach ($this->validators as $validator) {
                                if(!$validator->valid($var)) {
                                    $this->error = $validator->get_error();
                                    break;
                                }
                            }
                        }
                    }
                    if(count($vals)>0) {
                        $this->value[] = $vals;
                    }
                }
            }
        }
        return count($this->error)==0;
    }
}

?>
