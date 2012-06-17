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
    protected $avisos;
    protected $user;
    protected $header;

    public function ini() {
        Eruda::getDBConnector()->connect();
        
        $this->user = Eruda_Helper_Auth::getUser();
        
        if(!$this->_onlyheader) {
            $this->cats = Eruda_Mapper_Category::All();
            $this->archives = Eruda_Mapper_Entry::getArchive();
            $this->avisos = Eruda_Mapper_Aviso::getLast(3);
            $this->header = new Eruda_Header_HTML();
            $this->header->setType('HTML5');
            $this->header->setMetatag('Description', 'FallenSoulFansub, todos nuestros mangas on-line para tu disfrute.');
            $this->header->append2Title(Eruda::getEnvironment()->getTitle());
            $this->header->addCSS('style.css');
            $this->header->addCSS('cats.css');
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
            
            $page = new Eruda_Model_Page('/', 1, ceil(Eruda_Mapper_Entry::countFromAll()/Eruda::getEnvironment()->getEntriesPerPage()));
            
            
            $model = new Eruda_Model_ListEntries($this->user, $this->cats, $this->archives, $this->avisos, $entries, $page);
            
            $view = new Eruda_View_HTML('basic', array('section'=>'entriesperpage', 'lateral'=>'lateralblog'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function Paginacion() {        
        if(!$this->_onlyheader) {
            $pag = $this->_params[0];
            $maxPages = ceil(Eruda_Mapper_Entry::countFromAll()/Eruda::getEnvironment()->getEntriesPerPage());
            
            if($pag>$maxPages) {
                header( 'Location: /p'.$maxPages.'/' ) ;
                $this->end();
                exit();
            }
            
            $entries = Eruda_Mapper_Entry::getFromAll(($pag-1)*Eruda::getEnvironment()->getEntriesPerPage(), Eruda::getEnvironment()->getEntriesPerPage());
            
            
            self::setEntries($entries);
            
            $page = new Eruda_Model_Page('/', $pag, $maxPages);
            
            
            $model = new Eruda_Model_ListEntries($this->user, $this->cats, $this->archives, $this->avisos, $entries, $page);
            
            $view = new Eruda_View_HTML('basic', array('section'=>'entriesperpage', 'lateral'=>'lateralblog'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function CategoriaIndex() {        
        if(!$this->_onlyheader) {
            $catLink = $this->_params[0];
            $categoria = Eruda_Mapper_Category::getLink($catLink);
            if($categoria==null) {
                return new Eruda_CF('Error', 'E404');
            }
            
            $maxPages = ceil($categoria->get_count()/Eruda::getEnvironment()->getEntriesPerPage());
            
            $entries = Eruda_Mapper_Entry::getFromCat($categoria->get_id(), 0, Eruda::getEnvironment()->getEntriesPerPage());
            self::setEntries($entries);
            $page = new Eruda_Model_Page('/'.$catLink.'/', 1, $maxPages);
            
            $model = new Eruda_Model_ListEntries($this->user, $this->cats, $this->archives, $this->avisos, $entries, $page, 'Archivadas en : '.$categoria->get_name());
            
            $view = new Eruda_View_HTML('basic', array('section'=>'entriesperpage', 'lateral'=>'lateralblog'));
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
            if($categoria==null) {
                return new Eruda_CF('Error', 'E404');
            }
            $maxPages = ceil($categoria->get_count()/Eruda::getEnvironment()->getEntriesPerPage());
            if($pag>$maxPages) {
                header( 'Location: /'.$catLink.'/p'.$maxPages.'/' ) ;
                $this->end();
                exit();
            }
            
            $entries = Eruda_Mapper_Entry::getFromCat($categoria->get_id(), ($pag-1)*Eruda::getEnvironment()->getEntriesPerPage(), $maxPages);
            
            self::setEntries($entries);
            
            $page = new Eruda_Model_Page('/'.$catLink.'/', $pag, ceil($categoria->get_count()/Eruda::getEnvironment()->getEntriesPerPage()));
            
            $model = new Eruda_Model_ListEntries($this->user, $this->cats, $this->archives, $this->avisos, $entries, $page, 'Archivadas en : '.$categoria->get_name());
            
            $view = new Eruda_View_HTML('basic', array('section'=>'entriesperpage', 'lateral'=>'lateralblog'));
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
            if(!(count($entries)>0)) {
                return new Eruda_CF('Error', 'E404');
            }
            self::setEntries($entries);
            
            $model = new Eruda_Model_ListEntries($this->user, $this->cats, $this->archives, $this->avisos, $entries, null , Eruda_Helper_Parser::parseMonth($month).' del '.$year);
            
            $view = new Eruda_View_HTML('basic', array('section'=>'entriesperpage', 'lateral'=>'lateralblog'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function View() {        
        if(!$this->_onlyheader) {
            $id = $this->_params[0];
            $link = $this->_params[1];
            $entry = Eruda_Mapper_Entry::get($id);
            if(!(count($entry)>0)) {
                return new Eruda_CF('Error', 'E404');
            }
            if(Eruda_Helper_Parser::Text2Link($entry->get_title())!=$link){
                header( 'Location: /'.$id.'/'.Eruda_Helper_Parser::Text2Link($entry->get_title()).'/' ) ;
                $this->end();
                exit();
            }
            self::setEntry($entry);
            
            $comments = Eruda_Mapper_Comment::getFrom($id);
            self::setComments($comments);
            
            $model = new Eruda_Model_ViewEntry($this->user, $this->cats, $this->archives, $this->avisos, $entry, $comments);
            
            $this->header->addJavascript('comment.js');
            
            $view = new Eruda_View_HTML('basic', array('section'=>'entry', 'lateral'=>'lateralblog'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function Comentar() {       
        if(!($this->user->get_id()>0)) {
            return new Eruda_CF('Error', 'E550');
        }
        
        $eid = $this->_params[0];
        $entry = Eruda_Mapper_Entry::get($eid);
        if(!(count($entry)>0)) {
            return new Eruda_CF('Error', 'E404');
        }
            
        $valid = true;
        $msg = null;
        
        $form = new Eruda_Form('Message');
        $form->addField('msg', 
            new Eruda_Field('text', 'El comentario no puede estar en blanco.')
        );
            
        $error = null;
        $model = null;
        if($form->validate()) {
            $model = $form->getValue();
            $msg = utf8_decode(htmlspecialchars ($model->get_msg()));
        } else {
            $model = $form->getValue();
            $valid = false;
            $error = $form->getErrors();
        }
        
        $comtxt = $model->get_msg();
        
        if($valid) {
            $com = new Eruda_Model_Comment();
            $com->set_entry_id($eid);
            $com->set_author($this->user);
            $com->set_author_id($this->user->get_id());
            $com->set_text($msg);
            if(Eruda_Helper_Auth::canAdmin($this->user)){
                $com->set_valid(2);
            } else if(Eruda_Helper_Auth::validComments($this->user)){
                $com->set_valid(1);
            } else {
                $com->set_valid(0);
            }
            $com = Eruda_Mapper_Comment::save($com);
            if($com->get_id()>0){
                header( 'Location: /'.$eid.'/'.Eruda_Helper_Parser::Text2Link($entry->get_title()).'/' ) ;
                $this->end();
                exit();
            } else {
                return new Eruda_CF('Error', 'E500');
            }
        } else {
            if(!$this->_onlyheader) {
                $link = $this->_params[1];
                
                if(Eruda_Helper_Parser::Text2Link($entry->get_title())!=$link){
                    header( 'Location: /'.$eid.'/'.Eruda_Helper_Parser::Text2Link($entry->get_title()).'/' ) ;
                    $this->end();
                    exit();
                }
                self::setEntry($entry);

                $comments = Eruda_Mapper_Comment::getFrom($eid);
                self::setComments($comments);

                $model = new Eruda_Model_ViewEntry($this->user, $this->cats, $this->archives, $this->avisos, $entry, $comments, $error, $comtxt);

                $this->header->addJavascript('comment.js');

                $view = new Eruda_View_HTML('basic', array('section'=>'entry', 'lateral'=>'lateralblog'));
                $view->setHeader($this->header);
                return new Eruda_MV($view, $model);
            }
            return null;
        }
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
                //$entry->set_tags(Eruda_Mapper_Tag::tagsfromEntry($id));
                $entry->set_text(Eruda_Helper_Parser::parseText($entry->get_text()));
                
                $entry->set_comments(Eruda_Mapper_Comment::getCountFrom($id));
    }
    
    static function setComments(&$comments){
        foreach($comments as $comment){
            self::setComment($comment);
        }
    }
    
    static function setComment(&$comment){
        $comment->set_author(Eruda_Mapper_User::get($comment->get_author_id()));
        $comment->set_text(Eruda_Helper_Parser::parseText($comment->get_text()));
    }
}

?>
