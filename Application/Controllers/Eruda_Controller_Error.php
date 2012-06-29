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
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
            $pageURL .= "s";
        $pageURL .= "://";
        if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80")
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        else
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        
        $this->error->set_url($pageURL);
        
        if(!$this->_onlyheader) {
            $this->header = new Eruda_Header_HTML();
            $this->header->setType('HTML5');
            $this->header->setMetatag('Description', 'FallenSoulFansub, todos nuestros mangas on-line para tu disfrute.');
            $this->header->addCSS('error.css');
            $this->header->addJavascript('jquery.js');
            $this->header->addJavascript('error.js');
            $this->header->append2Title(Eruda::getEnvironment()->getTitle());
        }
    }
    
    public function end() {}
    
    
    function E404() {        
        header('HTTP/1.0 404 Not Found');
        header("Status: 404 Not Found");
        if(!$this->_onlyheader) {
            $this->error->set_message('404 Not Found');
            $this->error->set_extra('La página que estas buscando no existe o ha sido movida.<br />
<a href="/">Volver</a>');
            $this->header->append2Title('404 Not Found');
            $view = new Eruda_View_HTML('error');
            $view->setHeader($this->header);
            return new Eruda_MV($view, $this->error);
        }
        return null;
    }
    function E500() {        
        header('HTTP/1.0 500');
        header('Status: 500');
        if(!$this->_onlyheader) {
            $this->error->set_message('500 Internal Server Error');
            $this->error->set_extra('Ha ocurrido un error interno<br />
FallenSoul volverá a estar online muy pronto.<br />
Mientras puedes seguir informado en el <a href="http://twitter.com/#!/gaixas1" >twitter</a> y el <a href="http://www.facebook.com/pages/FallenSoul-Fansub/149614985063701" >caralibro</a> del fansub');
            $this->header->append2Title('500 Internal Server Error');
            $view = new Eruda_View_HTML('error');
            $view->setHeader($this->header);
            return new Eruda_MV($view, $this->error);
        }
        return null;
    }
    function E550() {        
        header('HTTP/1.0 550');
        header('Status: 550');
        if(!$this->_onlyheader) {
            $this->error->set_message('550 Permission Denied');
            $this->error->set_extra('No tienes permisos para realizar esta acción.<br />
<a href="/">Volver</a>');
            $this->header->append2Title('550 Permission Denied');
            $view = new Eruda_View_HTML('error');
            $view->setHeader($this->header);
            return new Eruda_MV($view, $this->error);
        }
        return null;
    }
}

?>