<?php
/**
 * Description of eField => AreaArray
 * Eruda Form Field, AreaArray
 * 
 * Extension of eField:
 *  return a matrix from a text by line and coma
 *
 * @author gaixas1
 */
class eField_AreaArray extends eField {
    function validate($from = null){
        if($from == null) {
            $from = $_POST;
        }
        $this->value = array();
        if(isset($from[$this->form_field]) && strlen($from[$this->form_field])>0){
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