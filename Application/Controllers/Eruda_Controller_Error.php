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
    protected $error;
    
    public function ini() {
        
        $this->error = new Eruda_Model_Error();
        
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on")
            $pageURL .= "s";
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80")
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        else
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        
        $this->error->set_url($pageURL);
        
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
            $this->error->set_message('SERVER Error');
            $this->header->append2Title('SERVER ERROR');
            $view = new Eruda_View_HTML('error');
            $view->setHeader($this->header);
            return new Eruda_MV($view, $this->error);
        }
        return null;
    }
    function E404() {        
        header('Status: 404');
        if(!$this->_onlyheader) {
            $this->error->set_message('PAGE NOT FOUND');
            $this->header->append2Title('Pagina no encontrada');
            $view = new Eruda_View_HTML('error');
            $view->setHeader($this->header);
            return new Eruda_MV($view, $this->error);
        }
        return null;
    }
}

?>
