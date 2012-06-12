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
    protected $archives;
    protected $user;
    protected $header;

    public function ini() {
        Eruda::getDBConnector()->connect();
        
        $this->user = Eruda_Helper_Auth::getUser();
        
        if(!$this->_onlyheader) {
            $this->cats = Eruda_Mapper_Category::All();
            $this->archives = Eruda_Mapper_Entry::getArchive();
            $this->header = new Eruda_Header_HTML();
            $this->header->setType('HTML5');
            $this->header->setMetatag('Description', 'FallenSoulFansub, todos nuestros mangas on-line para tu disfrute.');
            $this->header->append2Title(Eruda::getEnvironment()->getTitle());
            $this->header->addCSS('style.css');
            $this->header->addCSS('anime.css');
            $this->header->addCSS('manga.css');
            $this->header->addJavascript('jquery.js');
            $this->header->addJavascript('basic.js');
        }
    }
    
    public function end() {    
        Eruda::getDBConnector()->disconnect();
    }
    
    function index() {        
        if(!$this->_onlyheader) {
            $entries = Eruda_Mapper_Entry::getFromAll(0, Eruda::getEnvironment()->getEntriesPerPage());
            self::setEntries($entries);
            
            $page = new Eruda_Model_Page('/', 1, floor(Eruda_Mapper_Entry::countFromAll()/Eruda::getEnvironment()->getEntriesPerPage()));
            
            
            $model = new Eruda_Model_ListEntries($this->user, $this->cats, $this->archives, $entries, $page);
            
            $view = new Eruda_View_HTML('basic', array('section'=>'entriesperpage'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function Paginacion() {        
        if(!$this->_onlyheader) {
            $pag = $this->_params[0];
            $entries = Eruda_Mapper_Entry::getFromAll($pag*Eruda::getEnvironment()->getEntriesPerPage(), Eruda::getEnvironment()->getEntriesPerPage());
            self::setEntries($entries);
            
            $page = new Eruda_Model_Page('/', $pag, floor(Eruda_Mapper_Entry::countFromAll()/Eruda::getEnvironment()->getEntriesPerPage()));
            
            
            $model = new Eruda_Model_ListEntries($this->user, $this->cats, $this->archives, $entries, $page);
            
            $view = new Eruda_View_HTML('basic', array('section'=>'entriesperpage'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function CategoriaIndex() {        
        if(!$this->_onlyheader) {
            $catLink = $this->_params[0];
            $categoria = Eruda_Mapper_Category::getLink($catLink);
            $entries = Eruda_Mapper_Entry::getFromCat($categoria->get_id(), 0, Eruda::getEnvironment()->getEntriesPerPage());
            self::setEntries($entries);
            
            $page = new Eruda_Model_Page('/'.$catLink.'/', 1, floor($categoria->get_count()/Eruda::getEnvironment()->getEntriesPerPage()));
            
            $model = new Eruda_Model_ListEntries($this->user, $this->cats, $this->archives, $entries, $page, 'Archivadas en : '.$categoria->get_name());
            
            $view = new Eruda_View_HTML('basic', array('section'=>'entriesperpage'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function CategoriaPaginacion() {        
        if(!$this->_onlyheader) {
            $pag = $this->_params[1];
            $catLink = $this->_params[0];
            $categoria = Eruda_Mapper_Category::getLink($catLink);
            $entries = Eruda_Mapper_Entry::getFromCat($categoria->get_id(), $pag*Eruda::getEnvironment()->getEntriesPerPage(), Eruda::getEnvironment()->getEntriesPerPage());
            self::setEntries($entries);
            
            $page = new Eruda_Model_Page('/'.$catLink.'/', $pag, floor($categoria->get_count()/Eruda::getEnvironment()->getEntriesPerPage()));
            
            $model = new Eruda_Model_ListEntries($this->user, $this->cats, $this->archives, $entries, $page, 'Archivadas en : '.$categoria->get_name());
            
            $view = new Eruda_View_HTML('basic', array('section'=>'entriesperpage'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function Archivo() {        
        if(!$this->_onlyheader) {
            $month = $this->_params[0];
            $year = $this->_params[1];
            $entries = Eruda_Mapper_Entry::getFromArchive($month, $year);
            self::setEntries($entries);
            
            $model = new Eruda_Model_ListEntries($this->user, $this->cats, $this->archives, $entries, null , Eruda_Helper_Parser::parseMonth($month).' del '.$year);
            
            $view = new Eruda_View_HTML('basic', array('section'=>'entriesperpage'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    static function setEntries(&$entries){
        foreach($entries as $entry){
            /** @var Eruda_Model_Entry $entry **/
                $id = $entry->get_id();
                $cats_id = Eruda_Mapper_Category::IdsfromEntry($id);
                $entry->set_cats_id($cats_id);
                $cats = array();
                foreach($cats_id as $catId){
                    $cats[] = Eruda_Mapper_Category::get($catId);
                }
                $entry->set_cats($cats);
                $entry->set_tags(Eruda_Mapper_Tag::tagsfromEntry($id));
                $entry->set_text(Eruda_Helper_Parser::parseText($entry->get_text()));
            }
    }
}

?>
