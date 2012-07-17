<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Index
 *
 * @author gaixas1
 */
class eController_Index extends eController {
    protected $header;
    
    public function ini() {
        eCore::getDBConnector()->connect();
        $this->header = new eHeader_HTML();
        $this->header->setType('HTML5');
        $this->header->append2Title(eEnvironment::get_title());
        
        $this->header->addCSS('style.css');
    }
    
    public function end() {
        eCore::getDBConnector()->disconnect();
    }
    
    public function Index(){
        
        $view = new eView_HTML('basic', array());
        $view->setHeader($this->header);
        
        return new eMV($view, $model);
    }
}

?>
