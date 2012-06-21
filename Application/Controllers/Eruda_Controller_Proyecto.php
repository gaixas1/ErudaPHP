<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Controller_Proyecto
 *
 * @author gaixas1
 */
class Eruda_Controller_Proyecto extends Eruda_Controller {
    
    protected $header;
    protected $series;
    protected $avisos;
    
    public function ini() {
        Eruda::getDBConnector()->connect();
        
        $this->user = Eruda_Helper_Auth::getUser();
        
        if(!$this->_onlyheader) {
            $this->avisos = Eruda_Mapper_Aviso::getLast(3);
            $this->header = new Eruda_Header_HTML();
            $this->header->setType('HTML5');
            $this->header->setMetatag('Description', 'FallenSoulFansub, todos nuestros mangas on-line para tu disfrute.');
            $this->header->append2Title(Eruda::getEnvironment()->getTitle());
            $this->header->addCSS('style.css');
            $this->header->addCSS('proyecto.css');
            $this->header->addJavascript('jquery.js');
            $this->header->addJavascript('basic.js');
            $this->header->addJavascript('fb.js');
        }
        
    }
    public function end() {
        Eruda::getDBConnector()->disconnect();
    }
    
    public function Index() {
        if(!$this->_onlyheader) {
            $model = new Eruda_Model_Manganime($this->user, $this->avisos, $this->series=array(), array());
            
            $view = new Eruda_View_HTML('basic', array('section'=>'manganime', 'lateral'=>'lateralmanganime'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
}

?>
