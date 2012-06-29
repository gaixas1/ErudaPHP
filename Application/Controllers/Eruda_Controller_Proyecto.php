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
    protected $proyectos;
    protected $list;
    protected $avisos;
    protected $device;
    
    public function ini() {
        Eruda::getDBConnector()->connect();
        
        $this->user = Eruda_Helper_Auth::getUser();
        
        if(!$this->_onlyheader) {
            if(Eruda::getEnvironment()->isMobile()) {
                $this->device='mobile_';
            }else{
                $this->device='';
                $this->avisos = Eruda_Mapper_Aviso::getLast(3);
            }
            $this->header = new Eruda_Header_HTML();
            $this->header->setType('HTML5');
            $this->header->setMetatag('Description', 'FallenSoulFansub, todos nuestros mangas on-line para tu disfrute.');
            $this->header->append2Title(Eruda::getEnvironment()->getTitle());
            $this->header->addCSS($this->device.'style.css');
            $this->header->addCSS($this->device.'proyecto.css');
            $this->header->addJavascript('jquery.js');
            $this->header->addJavascript('basic.js');
            
            if($this->user->get_id()>0)
                $this->header->addJavascript('fb_connected.js');
            else
                $this->header->addJavascript('fb_disconnected.js');
            
            $this->proyectos = Eruda_Mapper_Proyecto::getAll();
            foreach($this->proyectos as $p) {
                $this->list[$p->get_estado()][$p->get_tipo()][] = $p;
            }
        }
        
    }
    public function end() {
        Eruda::getDBConnector()->disconnect();
    }
    
    public function Index() {
        $this->header->prepend2Title('Proyectos');    
        if(!$this->_onlyheader) {
            $items = array();
            for($i = 0; $i<3 && $i < count($this->proyectos); $i++){
                $items[] = $this->proyectos[$i];
            }
            
            $model = new Eruda_Model_ProyectosList($this->user, $this->avisos, $this->list, $items);
            
            $view = new Eruda_View_HTML($this->device.'basic', array('section'=>'proyectos', 'lateral'=>'lateralproyectos'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    public function Serie() {
        $id = $this->_params[0];
        $link = $this->_params[1];
        if(!$this->_onlyheader) {
            
            $p = Eruda_Mapper_Proyecto::get($id);
            
            if(!$p) {
                return new Eruda_CF('Error', 'E404');
            }
            if(Eruda_Helper_Parser::Text2Link($p->get_serie())!=$link){
                header( 'Location: /proyectos/'.$id.'/'.Eruda_Helper_Parser::Text2Link($p->get_serie()).'/' ) ;
                $this->end();
                exit();
            }
            $this->header->prepend2Title(ucfirst(Eruda_Helper_Parser::Link2Text($p->get_serie()))); 
            $this->header->prepend2Title('Proyectos');    
            
            $items = array($p);
            $model = new Eruda_Model_ProyectosList($this->user, $this->avisos, $this->list, $items);
            
            $view = new Eruda_View_HTML($this->device.'basic', array('section'=>'proyectos', 'lateral'=>'lateralproyectos'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
}
?>