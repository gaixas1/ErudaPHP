<?php
/**
 * Description of eController => Error
 *
 * AppController for con error pages
 * 
 * @author gaixas1
 */
class eController_Error extends eController {
    protected $error;
    protected $header;
    
    public function ini() {
        $this->error = new eModel_Error();
        $this->error->set_url($this->getURL());
        
        
        $this->header = new eHeader_HTML();
        $this->header->setType('HTML5');
        $this->header->append2Title(eEnvironment::get_title());
        
        $this->header->addCSS('error.css');
    }
    
    public function end() {}
    
    
    function E404() {        
        header('HTTP/1.0 404 Not Found');
        header("Status: 404 Not Found");
        
        $this->header->append2Title('Página no encontrada');
        
        $view = new eView_HTML('error', array());
        $view->setHeader($this->header);
        
        return new eMV($view, $this->error);
    }
    function E500() {        
        header('HTTP/1.0 500');
        header('Status: 500');
        
        $this->header->append2Title('Error de sistema');
        
        $view = new eView_HTML('error', array());
        $view->setHeader($this->header);
        
        return new eMV($view, $this->error);
    }
    function E550() {        
        header('HTTP/1.0 550');
        header('Status: 550');
        
        $this->header->append2Title('Error de sistema');
        
        $view = new eView_HTML('error', array());
        $view->setHeader($this->header);
        
        return new eMV($view, $this->error);
    }
    
    
    
    private function getURL(){
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
            $pageURL .= "s";
        $pageURL .= "://";
        if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80")
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        else
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        
        return $pageURL;
    }
}
?>