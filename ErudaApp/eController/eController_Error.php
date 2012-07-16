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
    
    public function ini() {
        $this->error = new eModel_Error();
        
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
            $pageURL .= "s";
        $pageURL .= "://";
        if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80")
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        else
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        
        $this->error->set_url($pageURL);
        
        //Insert Code Here
    }
    
    public function end() {}
    
    
    function E404() {        
        header('HTTP/1.0 404 Not Found');
        header("Status: 404 Not Found");
        
        //Insert Code Here
        
        return null;
    }
    function E500() {        
        header('HTTP/1.0 500');
        header('Status: 500');
        
        //Insert Code Here
        
        return null;
    }
    function E550() {        
        header('HTTP/1.0 550');
        header('Status: 550');
        
        //Insert Code Here
        
        return null;
    }
}
?>