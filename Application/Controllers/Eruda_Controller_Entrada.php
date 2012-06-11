<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Controller_Entry
 *
 * @author gaixas1
 */
class Eruda_Controller_Entrada extends Eruda_Controller{
    protected $cats;
    protected $user;
    protected $header;

    public function ini() {
        Eruda::getDBConnector()->connect();
        
        $this->user = Eruda_Helper_Auth::getUser();
        
        if(!$this->_onlyheader) {
            $this->cats = Eruda_Mapper_Category::All();
            $this->header = new Eruda_Header_HTML();
            $this->header->setType('HTML5');
            $this->header->setMetatag('Description', 'FallenSoulFansub, todos nuestros mangas on-line para tu disfrute.');
            $this->header->append2Title(Eruda::getEnvironment()->getTitle());
        }
    }
    
    public function end() {    
        Eruda::getDBConnector()->disconnect();
    }
    
    function index() {        
        if(!$this->_onlyheader) {
            $entries = Eruda_Mapper_Entry::getFromAll(0, Eruda::getEnvironment()->getEntriesPerPage());
            
            $model = new Eruda_Model_ListEntries($this->user, $this->cats, $entries);
            $view = new Eruda_View_HTML('entriesperpage');
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
}

?>
