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
            
            //Avisos
            $avisos = Eruda_Mapper_Aviso::getLast(3);
            $model->add_data('aviso', $avisos);
            
            //Estadisticas
            $model->add_data('nent', Eruda_Mapper_Entry::countFromAll());
            $ncom = Eruda_Mapper_Comment::countFromAll();
            $ncomval = $ncomesp = $ncomspm = 0;
            foreach($ncom as $c) {
                switch($c['valid']) {
                    case '1': $ncomval = $c['count']; break;
                    case '0': $ncomesp = $c['count']; break;
                    case '-1': $ncomspm = $c['count']; break;
                }
            }
            $model->add_data('ncomval', $ncomval);
            $model->add_data('ncomesp', $ncomesp);
            $model->add_data('ncomspm', $ncomspm);
            
            //MangaAnime
            $model->add_data('lastmanga', Eruda_Mapper_Manga::getLasts(5));
            $model->add_data('lastanime', Eruda_Mapper_Anime::getLasts(5));
            $model->add_data('seriesmanga', Eruda_Mapper_Manga::getSeries());
            $model->add_data('seriesanime', Eruda_Mapper_Anime::getSeries());
            
            
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
            
            $model->add_data('entradas1',Eruda_Mapper_Entry::Mini(0,30));
            $model->add_data('entradas2',Eruda_Mapper_Entry::Mini(30,30));
            
            $view = new Eruda_View_HTML('admin', array('section'=>'entradas'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function EntradaForm() {        
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'entradas/' => 'Entradas',
                'entradas/new/' => 'Nueva'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $model->add_data('entrada',new Eruda_Model_Entry());
            $model->add_data('categories',Eruda_Mapper_Category::All());
            $model->add_data('categoriesId',array());
            $model->add_data('entradaparsed',null);
            
            $this->header->addJavascript('admin.entrada.js');
            $view = new Eruda_View_HTML('admin', array('section'=>'entradaform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function EntradaGet() {        
        $id = $this->_params[0];
        $entry = Eruda_Mapper_Entry::get($id);
        if($entry==null) {
            return new Eruda_CF('Error', 'E404');
        }
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'entradas/' => 'Entradas',
                'entradas/new/' => 'Editar'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $entryp = Eruda_Mapper_Entry::get($id);
            self::setEntry($entryp);
            $model->add_data('entrada', $entry);
            $model->add_data('categories',Eruda_Mapper_Category::All());
            $model->add_data('categoriesId',Eruda_Mapper_Category::IdsfromEntry($id));
            $model->add_data('entradaparsed',$entryp);
            
            
            $this->header->addJavascript('admin.entrada.js');
            $this->header->addCSS('anime.css');
            $this->header->addCSS('manga.css');
            $view = new Eruda_View_HTML('admin', array('section'=>'entradaform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function EntradaPut() {      
        $form = new Eruda_Form('Entry');
        $form->addField('title', new Eruda_Field('title'));
        $form->addField('text', new Eruda_Field('text'));
            
        $form->validate();
        $entry = $form->getValue();
        $entry->set_author_id($this->user->get_id());
        Eruda_Mapper_Entry::save($entry);  
        if(!($entry->get_id()>0)) {
            return new Eruda_CF('Error', 'E500');
        }
        $id = $entry->get_id();
        $formc = new Eruda_Form();
        $formc->addField('cats', new Eruda_Field_Array('cats'));
            
        $formc->validate();
        $cats = $formc->getValue();
        
        foreach($cats['cats'] as $cat) {
            Eruda_Mapper_Category::setEntryCat($id, $cat);
        }
        
        header( 'Location: /admin/entradas/'.$id.'/') ;
        $this->end();
        exit();
    }
    
    function EntradaPost() {  
        $id = $this->_params[0];
        $entry = Eruda_Mapper_Entry::get($id);
        if($entry==null) {
            return new Eruda_CF('Error', 'E404');
        }
        
        
        $form = new Eruda_Form('Entry');
        $form->addField('title', new Eruda_Field('title'));
        $form->addField('text', new Eruda_Field('text'));
            
        $form->validate();
        $entry = $form->getValue();
        $entry->set_id($id);
        
        Eruda_Mapper_Entry::update($entry);  
        if(!($entry->get_id()>0)) {
            return new Eruda_CF('Error', 'E500');
        }
        $formc = new Eruda_Form();
        $formc->addField('cats', new Eruda_Field_Array('cats'));
            
        $formc->validate();
        $cats = $formc->getValue();
        
        Eruda_Mapper_Category::unsetEntryCat($id);
        foreach($cats['cats'] as $cat) {
            Eruda_Mapper_Category::setEntryCat($id, $cat);
        }
        
        header( 'Location: /admin/entradas/'.$id.'/') ;
        $this->end();
        exit();
    }


    
    function CommentsList() {        
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'comentarios/' => 'Comentarios'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            $last = Eruda_Mapper_Comment::Last(10);
            self::setComments($last);
            $model->add_data('ultimos',  $last);
            
            $validar = Eruda_Mapper_Comment::Wait();
            self::setComments($validar);
            $model->add_data('pendientes',  $validar);
            
            $spam = Eruda_Mapper_Comment::Spam();
            self::setComments($spam);
            $model->add_data('spam',  $spam);
            
            $this->header->addJavascript('admin.comment.js');
            $view = new Eruda_View_HTML('admin', array('section'=>'comentarios'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }

    
    function CommentsValid() {      
        $id = $this->_params[0];
        $comment =Eruda_Mapper_Comment::get($id);
        
        Eruda_Mapper_Comment::validate($id);
        
        $user = Eruda_Mapper_User::get($comment->get_author_id());
        
        $actlevel = $user->get_level();
        if($actlevel<5){
            $user->set_level($actlevel+1);
            Eruda_Mapper_User::update($user);
        }
        header( 'Location: /admin/comentarios/') ;
        $this->end();
        exit();
    }
    
    function CommentsDelete() {      
        $id = $this->_params[0];
        $comment =Eruda_Mapper_Comment::get($id);
        Eruda_Mapper_Comment::delete($id);
        
        $user = Eruda_Mapper_User::get($comment->get_author_id());
        
        $actlevel = $user->get_level();
        if($actlevel>1){
            $user->set_level($actlevel-1);
            Eruda_Mapper_User::update($user);
        }
        
        header( 'Location: /admin/comentarios/') ;
        $this->end();
        exit();
    }



    
    function AvisosGet() {        
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'avisos/' => 'Avisos'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $last = Eruda_Mapper_Aviso::getLast(3);
            $model->add_data('ultimos',  $last);
            
            //$this->header->addJavascript('admin.avisos.js');
            $view = new Eruda_View_HTML('admin', array('section'=>'avisos'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function AvisosPost() {    
        $forma = new Eruda_Form();
        $forma->addField('avisos', new Eruda_Field_Array('aviso'));
        $forma->validate();
        $avisos = $forma->getValue();
        
        foreach($avisos['avisos'] as $k => $msg) {
            if($msg!=null && $msg!="") {
                $aviso = new Eruda_Model_Aviso();
                $aviso->set_id($k)->set_msg($msg);
                Eruda_Mapper_Aviso::update($aviso);
            }
        }
        
        header( 'Location: /admin/avisos/') ;
        $this->end();
        exit();
    }
    
    function AvisosPut() {      
        $forma = new Eruda_Form();
        $forma->addField('avisos', new Eruda_Field('aviso'));
        $forma->validate();
        $avisos = $forma->getValue();
        $msg = $avisos['avisos'];
        if($msg!=null && $msg!="") {
            $aviso = new Eruda_Model_Aviso();
            $aviso->set_msg($msg);
            Eruda_Mapper_Aviso::save($aviso);
        }
        
        header( 'Location: /admin/avisos/') ;
        $this->end();
        exit();
    }

    
    
    
    function MangaList() {        
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'manga/' => 'Manga'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $model->add_data('tipo','manga');
            $model->add_data('descargas',  Eruda_Mapper_Manga::getLasts(30));
            $model->add_data('series',Eruda_Mapper_Manga::getSeries());
            
            $view = new Eruda_View_HTML('admin', array('section'=>'manganime'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function AddMangaSerie() {      
        $forma = new Eruda_Form('MangaSerie');
        $forma->addField('serie', new Eruda_Field('title', 'No puede estar en blanco'));
        if($forma->validate()){
            $serie = $forma->getValue();
            $serie->set_serie(str_replace(' ', '_', $serie->get_serie()));
            if($exist = Eruda_Mapper_Manga::getSerieByTitle($serie->get_serie())) {
                header( 'Location: /admin/manga/serie/'.$exist->get_id().'/') ;
            } else {
                Eruda_Mapper_Manga::saveSerie($serie);
                header( 'Location: /admin/manga/serie/'.$serie->get_id().'/') ;
            }
        } else {
            header( 'Location: /admin/manga/') ;
        }
        $this->end();
        exit();
    }
    
    function MangaSerieGet() {         
        $id = $this->_params[0];  
        if(!($serie = Eruda_Mapper_Manga::getSerie($id))) {
            return new Eruda_CF('Error', 'E404');
        }
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'manga/' => 'Manga',
                'manga/serie/'.$id.'/' => Eruda_Helper_Parser::Link2Text($serie->get_serie())
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $model->add_data('tipo','manga');
            $model->add_data('serie', $serie);
            
            $view = new Eruda_View_HTML('admin', array('section'=>'manganimeserie'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function MangaSeriePost() {
        $id = $this->_params[0];  
        if(!Eruda_Mapper_Manga::getSerie($id)) {
            return new Eruda_CF('Error', 'E404');
        }    
        $forma = new Eruda_Form('MangaSerie');
        $forma->addField('serie', new Eruda_Field('title', 'No puede estar en blanco'));
        $forma->addField('tomos', new Eruda_Field('tomos'));
        if($forma->validate()){
            $serie = $forma->getValue();
            $serie->set_serie(str_replace(' ', '_', $serie->get_serie()));
            $serie->set_id($id);
            Eruda_Mapper_Manga::updateSerie($serie);
            header( 'Location: /admin/manga/serie/'.$id.'/') ;
        } else {
            header( 'Location: /admin/manga/') ;
        }
        $this->end();
        exit();
    }
    
    function MangaSerieDelete() {
        $id = $this->_params[0];  
        Eruda_Mapper_Manga::deleteSerie($id);
        header( 'Location: /admin/manga/') ;
        $this->end();
        exit();
    }
    
    
    
    function AnimeList() {        
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'anime/' => 'Anime/Dorama'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $model->add_data('tipo','anime');
            $model->add_data('descargas',  Eruda_Mapper_Anime::getLasts(30));
            $model->add_data('series',Eruda_Mapper_Anime::getSeries());
            
            $view = new Eruda_View_HTML('admin', array('section'=>'manganime'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }

    
    function AddAnimeSerie() {      
        $forma = new Eruda_Form('AnimeSerie');
        $forma->addField('serie', new Eruda_Field('title', 'No puede estar en blanco'));
        if($forma->validate()){
            $serie = $forma->getValue();
            $serie->set_serie(str_replace(' ', '_', $serie->get_serie()));
            
            if($exist = Eruda_Mapper_Anime::getSerieByTitle($serie->get_serie())) {
                header( 'Location: /admin/anime/serie/'.$exist->get_id().'/') ;
            } else {
                Eruda_Mapper_Anime::saveSerie($serie);
                header( 'Location: /admin/anime/serie/'.$serie->get_id().'/') ;
            }
        } else {
            header( 'Location: /admin/anime/') ;
        }
        $this->end();
        exit();
    }

    
    function AnimeSerieGet() {         
        $id = $this->_params[0];  
        if(!($serie = Eruda_Mapper_Anime::getSerie($id))) {
            return new Eruda_CF('Error', 'E404');
        }
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'anime/' => 'Anime',
                'anime/serie/'.$id.'/' => Eruda_Helper_Parser::Link2Text($serie->get_serie())
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $model->add_data('tipo','anime');
            $model->add_data('serie', $serie);
            
            $view = new Eruda_View_HTML('admin', array('section'=>'manganimeserie'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function AnimeSeriePost() {
        $id = $this->_params[0];  
        if(!Eruda_Mapper_Anime::getSerie($id)) {
            return new Eruda_CF('Error', 'E404');
        }    
        $forma = new Eruda_Form('AnimeSerie');
        $forma->addField('serie', new Eruda_Field('title', 'No puede estar en blanco'));
        $forma->addField('cont', new Eruda_Field('cont'));
        if($forma->validate()){
            $serie = $forma->getValue();
            $serie->set_serie(str_replace(' ', '_', $serie->get_serie()));
            $serie->set_id($id);
            Eruda_Mapper_Anime::updateSerie($serie);
            header( 'Location: /admin/anime/serie/'.$id.'/') ;
        } else {
            header( 'Location: /admin/anime/') ;
        }
        $this->end();
        exit();
    }
    
    function AnimeSerieDelete() {
        $id = $this->_params[0];  
        Eruda_Mapper_Anime::deleteSerie($id);
        header( 'Location: /admin/anime/') ;
        $this->end();
        exit();
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
