<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Controller_Admin
 *
 * @author gaixas1
 */
class Eruda_Controller_Admin extends Eruda_Controller {
    protected $user;
    protected $header;
    
    public function ini() {
        Eruda::getDBConnector()->connect();
        $this->user = Eruda_Helper_Auth::getUser();
        if(!Eruda_Helper_Auth::canAdmin($this->user)){
            header( 'Location: /' ) ;
            $this->end();
            exit();
        }
        
        if(!$this->_onlyheader) {
            $this->header = new Eruda_Header_HTML();
            $this->header->setType('HTML5');
            $this->header->setBaseURL(Eruda::getEnvironment()->getBaseURL().'admin/');
            $this->header->setMetatag('Description', 'FallenSoulFansub, todos nuestros mangas on-line para tu disfrute.');
            $this->header->append2Title(Eruda::getEnvironment()->getTitle().' Admin');
            $this->header->addCSS('admin.css');
            $this->header->addJavascript('jquery.js');
            $this->header->addJavascript('admin.js');
        }
        
    }
    public function end() {
        Eruda::getDBConnector()->disconnect();
    }
    
    
    function Index() {        
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $view = new Eruda_View_HTML('admin', array('section'=>'index'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function EntradasList() {        
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'entradas/' => 'Entradas'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $view = new Eruda_View_HTML('admin', array('section'=>'index'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
}

?>
