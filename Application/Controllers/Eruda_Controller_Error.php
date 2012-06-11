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
class Eruda_Controller_Error extends Eruda_Controller {
    //put your code here
    public function ini() {
        if(!$this->_onlyheader) {
            $this->header = new Eruda_Header_HTML();
            $this->header->setType('HTML5');
            $this->header->setMetatag('Description', 'FallenSoulFansub, todos nuestros mangas on-line para tu disfrute.');
            $this->header->append2Title(Eruda::getEnvironment()->getTitle());
        }
    }
    
    public function end() {}
    
    
    function E500() {        
        header('Status: 500');
        if(!$this->_onlyheader) {
            $this->header->append2Title('SERVER ERROR');
            $view = new Eruda_View_HTML('error');
            $view->setHeader($this->header);
            return new Eruda_MV($view, 'SERVER Error');
        }
        return null;
    }
}

?>
