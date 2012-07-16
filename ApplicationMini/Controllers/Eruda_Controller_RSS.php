<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Controller_rss
 *
 * @author gaixas1
 */
class Eruda_Controller_RSS extends Eruda_Controller {
    
    protected $cats;

    public function ini() {
        Eruda::getDBConnector()->connect();
        
        if(!$this->_onlyheader) {
            $this->cats = Eruda_Mapper_Category::All();
        }
    }
    
    public function end() {    
        Eruda::getDBConnector()->disconnect();
    }
    
    
    function index() {        
        if(!$this->_onlyheader) {
            $entries = Eruda_Mapper_Entry::getFromAll(0, Eruda_Environment::getEntriesPerPage()*5);
            self::setEntries($entries);
            
            $model = new Eruda_Model_RSS(Eruda_Environment::getTitle(), Eruda_Environment::getBaseURL(), 'es-es', 'FallenSoul Fansub', 'ErudaBlog', $entries);
            
            $view = new Eruda_View_RSS2();
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function all() {        
        if(!$this->_onlyheader) {
            $entries = Eruda_Mapper_Entry::getFromAll(0, 9999999);
            self::setEntries($entries);
            
            $model = new Eruda_Model_RSS(Eruda_Environment::getTitle(), Eruda_Environment::getBaseURL(), 'es-es', 'FallenSoul Fansub', 'ErudaBlog', $entries);
            
            $view = new Eruda_View_RSS2();
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    static function setEntries(&$entries){
        foreach($entries as $entry){
            self::setEntry($entry);
        }
    }
    static function setEntry(&$entry){
        $id = $entry->get_id();
        $cats_id = Eruda_Mapper_Category::IdsfromEntry($id);
        $entry->set_cats_id($cats_id);
        $cats = array();
        foreach($cats_id as $catId){
            $cats[] = Eruda_Mapper_Category::get($catId);
        }
        $entry->set_cats($cats);
        $entry->set_text(Eruda_Helper_Parser::parseText($entry->get_text()));
        $entry->set_author(Eruda_Mapper_User::get($entry->get_author_id()));
                
    }
}

?>