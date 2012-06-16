<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Controller_Error
 *
 * @author gaixas1
 */
class Eruda_Controller_Ajax extends Eruda_Controller {
    
    public function ini() {
    }
    
    public function end() {}
    
    
    function Preview() {
        if(!$this->_onlyheader) {
            $form = new Eruda_Form('Message');
            $form->addField('msg', 
                    new Eruda_Field('comment', 'El comentario no puede estar en blanco.')
                    );
            
            $model = null;
            if($form->validate()) {
                $model = $form->getValue();
                $model->set_msg(Eruda_Helper_Parser::parseText(utf8_decode(htmlspecialchars ($model->get_msg()))));
            } else {
                $model = new Eruda_Model_Message('El comentario no puede estar en blanco.');
                
            }
            
            $view = new Eruda_View_partHTML('msg');
            return new Eruda_MV($view, $model);
            
        }
        return null;
    }
}

?>
