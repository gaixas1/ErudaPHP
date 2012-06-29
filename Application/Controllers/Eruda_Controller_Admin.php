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
            $ncomval = 0;
            $ncomesp = 0;
            $ncomspm = 0;
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
            $this->header->append2Title('Entradas');
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
        $this->header->append2Title('Nueva entrada');
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
        $this->header->append2Title('Modificar entrada');
        $id = $this->_params[0];
        $entry = Eruda_Mapper_Entry::get($id);
        if($entry==null) {
            return new Eruda_CF('Error', 'E404');
        }
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'entradas/' => 'Entradas',
                'entradas/'.$id.'/' => 'Editar'
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
        $this->header->append2Title('Nueva entrada');  
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
        $this->header->append2Title('Modificar entrada');
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
        $this->header->append2Title('Comentarios');  
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
        $this->header->append2Title('Comentarios');  
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
        $this->header->append2Title('Comentarios');  
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
    
    
    
    function CategoriaList() {      
        $this->header->append2Title('Categorias');  
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'categorias/' => 'Categorias'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $cats = Eruda_Mapper_Category::All();
            $model->add_data('categorias',  $cats);
            
            $view = new Eruda_View_HTML('admin', array('section'=>'categorias'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function CategoriaGet() {        
        $this->header->append2Title('Modificar categoria');
        $id = $this->_params[0];
        $cat = Eruda_Mapper_Category::get($id);
        if($cat==null) {
            return new Eruda_CF('Error', 'E404');
        }
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'categorias/' => 'Categorias',
                'categorias/'.$id.'/' => 'Editar'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            $model->add_data('categoria',  $cat);
            
            $this->header->addJavascript('admin.categoria.js');
            $view = new Eruda_View_HTML('admin', array('section'=>'categoriaform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }

    
    function CategoriaPut() {    
        $this->header->append2Title('Nueva categoria');  
        $form = new Eruda_Form('Category');
        $form->addField('name', new Eruda_Field('name', 'name needed'));
            
        if($form->validate()) {
            $cat = $form->getValue();
            $cat->set_link(Eruda_Helper_Parser::Text2Link($cat->get_name()));
            $act = Eruda_Mapper_Category::getLink($cat->get_link());
            if($act!=null){
            header( 'Location: /admin/categorias/'.$act->get_id().'/') ;
            }else{
                Eruda_Mapper_Category::save($cat);  
                if(!($cat->get_id()>0)) {
                    return new Eruda_CF('Error', 'E500');
                }
                header( 'Location: /admin/categorias/'.$cat->get_id().'/') ;
            }
        } else {
            header( 'Location: /admin/categorias/') ;
        }
            $this->end();
            exit();
    }
    
    function CategoriaPost() {  
        $this->header->append2Title('Modificar categoria');
        $id = $this->_params[0];
        $cat = Eruda_Mapper_Category::get($id);
        if($cat==null) {
            return new Eruda_CF('Error', 'E404');
        }  
        $this->header->append2Title('Nueva categoria');  
        $form = new Eruda_Form('Category');
        $form->addField('name', new Eruda_Field('name', 'name needed'));
        $form->addField('link', new Eruda_Field('link', 'link needed'));
            
        if($form->validate()) {
            $cat = $form->getValue();
            $cat->set_id($id);
            $cat->set_link(Eruda_Helper_Parser::Text2Link($cat->get_link()));
            Eruda_Mapper_Category::update($cat);
        }
        header( 'Location: /admin/categorias/'.$id.'/') ;
        $this->end();
        exit();
    }
    
    function CategoriaDelete() {      
        $this->header->append2Title('Categorias');  
        $id = $this->_params[0];
        Eruda_Mapper_Category::delete($id);
        
        header( 'Location: /admin/categorias/') ;
        $this->end();
        exit();
    }
    
    
    function AvisosGet() {        
        $this->header->append2Title('Avisos');  
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
        $this->header->append2Title('Avisos');  
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
        $this->header->append2Title('Avisos');  
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
        $this->header->append2Title('Manga');  
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
        $this->header->append2Title('Manga');  
        $this->header->append2Title('Nueva serie');  
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
        $this->header->append2Title('Manga');  
        $this->header->append2Title('Modificar serie');    
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
        $this->header->append2Title('Manga');  
        $this->header->append2Title('Modificar serie');  
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
        $this->header->append2Title('Manga');  
        $this->header->append2Title('Eliminar serie');  
        $id = $this->_params[0];  
        Eruda_Mapper_Manga::deleteSerie($id);
        header( 'Location: /admin/manga/') ;
        $this->end();
        exit();
    }
    
    
    function MangaForm() {        
        $this->header->append2Title('Manga');  
        $this->header->append2Title('Nueva descarga');  
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'manga/' => 'Manga',
                'manga/new/' => 'Nueva Descarga'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $model->add_data('series',Eruda_Mapper_Manga::getSeries());
            $model->add_data('descarga',new Eruda_Model_Manga());
            
            $view = new Eruda_View_HTML('admin', array('section'=>'mangaform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function MangaGet() {        
        $this->header->append2Title('Manga');  
        $this->header->append2Title('Modifcar descarga');  
        $id = $this->_params[0];
        $descarga = Eruda_Mapper_Manga::get($id);
        if($descarga==null) {
            return new Eruda_CF('Error', 'E404');
        }
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'manga/' => 'Manga',
                'manga/'.$id.'/' => 'Editar'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $model->add_data('series',Eruda_Mapper_Manga::getSeries());
            $model->add_data('descarga',$descarga);
            
            $this->header->addCSS('manga.css');
            $view = new Eruda_View_HTML('admin', array('section'=>'mangaform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function MangaPut() {   
        $this->header->append2Title('Manga');  
        $this->header->append2Title('Nueva descarga');  
        $form = new Eruda_Form('Manga');
        $form->addField('serie', new Eruda_Field('serie', 'serie needed'));
        $form->addField('tomo', new Eruda_Field('tomo', 'tomo needed'));
        $form->addField('titulo', new Eruda_Field('descarga', 'descarga needed'));
        $form->addField('verO', new Eruda_Field('verO'));
        $form->addField('links', new Eruda_Field_AreaArray('links'));
        if($form->validate()){
            $download = $form->getValue();
            $download->parseLinks();
            Eruda_Mapper_Manga::save($download);  
            if(!($download->get_id()>0)) {
                return new Eruda_CF('Error', 'E500');
            }
            $aviso = new Eruda_Model_Aviso();
            $aviso->set_msg('Disponible '.Eruda_Helper_Parser::Link2Text($download->get_serie()).', '.$download->get_titulo());
            Eruda_Mapper_Aviso::save($aviso);
            $id = $download->get_id(); 
            self::uploadImage('imagen1', $id.'a', 'capturas_manga', false, 255);
            self::uploadImage('imagen2', $id.'b', 'capturas_manga', false, 255);
           
            header( 'Location: /admin/manga/'.$id.'/') ;
            $this->end();
            exit();
        }else if(!$this->_onlyheader) {
                $dir = array(
                    '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                    'manga/' => 'Manga',
                    'manga/new/' => 'Nueva Descarga'
                    );
                $model = new Eruda_Model_Admin($this->user, $dir);
                $download = $form->getValue();
                $model->add_data('series',Eruda_Mapper_Manga::getSeries());
                $model->add_data('descarga',$download);


                $this->header->addCSS('manga.css');
                $view = new Eruda_View_HTML('admin', array('section'=>'mangaform'));
                $view->setHeader($this->header);
                return new Eruda_MV($view, $model);
            
        }
        return null;
    }
    
    
    function MangaPost() {   
        $this->header->append2Title('Manga');  
        $this->header->append2Title('Modificar descarga');  
        $id = $this->_params[0];
        if(Eruda_Mapper_Manga::get($id)==null) {
            return new Eruda_CF('Error', 'E404');
        }
        $form = new Eruda_Form('Manga');
        $form->addField('serie', new Eruda_Field('serie', 'serie needed'));
        $form->addField('tomo', new Eruda_Field('tomo', 'tomo needed'));
        $form->addField('titulo', new Eruda_Field('descarga', 'descarga needed'));
        $form->addField('verO', new Eruda_Field('verO'));
        $form->addField('links', new Eruda_Field_AreaArray('links'));
        if($form->validate()){
            $download = $form->getValue();
            $download->set_id($id);
            $download->parseLinks();
            Eruda_Mapper_Manga::update($download);  
            self::uploadImage('imagen1', $id.'a', 'capturas_manga', false, 255);
            self::uploadImage('imagen2', $id.'b', 'capturas_manga', false, 255);
            header( 'Location: /admin/manga/'.$id.'/') ;
            $this->end();
            exit();
        }else if(!$this->_onlyheader) {
                $dir = array(
                    '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                    'manga/' => 'Manga',
                    'manga/new/' => 'Nueva Descarga'
                    );
                $model = new Eruda_Model_Admin($this->user, $dir);
                $download = $form->getValue();
                $model->add_data('series',Eruda_Mapper_Manga::getSeries());
                $model->add_data('descarga',$download);

                $this->header->addCSS('manga.css');
                $view = new Eruda_View_HTML('admin', array('section'=>'mangaform'));
                $view->setHeader($this->header);
                return new Eruda_MV($view, $model);
            
        }
        return null;
    }
    
    
    
    function AnimeList() {        
        $this->header->append2Title('Anime');  
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
        $this->header->append2Title('Anime');  
        $this->header->append2Title('Nueva serie');  
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
        $this->header->append2Title('Anime');  
        $this->header->append2Title('Modificar serie');  
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
        $this->header->append2Title('Anime');  
        $this->header->append2Title('Modificar serie');  
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
        $this->header->append2Title('Anime');  
        $this->header->append2Title('Eliminar serie');  
        $id = $this->_params[0];  
        Eruda_Mapper_Anime::deleteSerie($id);
        header( 'Location: /admin/anime/') ;
        $this->end();
        exit();
    }
    
    
    
    
    function AnimeForm() {       
        $this->header->append2Title('Anime');  
        $this->header->append2Title('Nueva descarga');   
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'anime/' => 'Anime',
                'anime/new/' => 'Nueva Descarga'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $model->add_data('series',Eruda_Mapper_Anime::getSeries());
            $model->add_data('descarga',new Eruda_Model_Anime());
            
            $view = new Eruda_View_HTML('admin', array('section'=>'animeform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function AnimeGet() {        
        $this->header->append2Title('Anime');  
        $this->header->append2Title('Modificar descarga');   
        $id = $this->_params[0];
        $descarga = Eruda_Mapper_Anime::get($id);
        if($descarga==null) {
            return new Eruda_CF('Error', 'E404');
        }
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'anime/' => 'Anime',
                'anime/'.$id.'/' => 'Editar'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $model->add_data('series',Eruda_Mapper_Anime::getSeries());
            $model->add_data('descarga',$descarga);
            
            $this->header->addCSS('anime.css');
            $view = new Eruda_View_HTML('admin', array('section'=>'animeform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function AnimePut() {   
        $this->header->append2Title('Anime');  
        $this->header->append2Title('Nueva descarga');   
        $form = new Eruda_Form('Anime');
        $form->addField('serie', new Eruda_Field('serie', 'serie needed'));
        $form->addField('cont', new Eruda_Field('cont', 'cont needed'));
        $form->addField('titulo', new Eruda_Field('descarga', 'descarga needed'));
        $form->addField('links', new Eruda_Field_AreaArray('links'));
        if($form->validate()){
            $download = $form->getValue();
            $download->parseLinks();
            Eruda_Mapper_Anime::save($download);  
            if(!($download->get_id()>0)) {
                return new Eruda_CF('Error', 'E500');
            }
            $aviso = new Eruda_Model_Aviso();
            $aviso->set_msg('Disponible '.Eruda_Helper_Parser::Link2Text($download->get_serie()).', '.$download->get_titulo());
            Eruda_Mapper_Aviso::save($aviso);
            $id = $download->get_id(); 
            self::uploadImage('imagen', $id, 'capturas_anime', false, 180);
           
            header( 'Location: /admin/anime/'.$id.'/') ;
            $this->end();
            exit();
        }else if(!$this->_onlyheader) {
                $dir = array(
                    '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                    'anime/' => 'Anime',
                    'anime/new/' => 'Nueva Descarga'
                    );
                $model = new Eruda_Model_Admin($this->user, $dir);
                $download = $form->getValue();
                $model->add_data('series',Eruda_Mapper_Anime::getSeries());
                $model->add_data('descarga',$download);


                $this->header->addCSS('anime.css');
                $view = new Eruda_View_HTML('admin', array('section'=>'animeform'));
                $view->setHeader($this->header);
                return new Eruda_MV($view, $model);
            
        }
        return null;
    }
    
    
    function AnimePost() {   
        $this->header->append2Title('Anime');  
        $this->header->append2Title('Modificar descarga');   
        $id = $this->_params[0];
        if(Eruda_Mapper_Anime::get($id)==null) {
            return new Eruda_CF('Error', 'E404');
        }
        $form = new Eruda_Form('Anime');
        $form->addField('serie', new Eruda_Field('serie', 'serie needed'));
        $form->addField('cont', new Eruda_Field('cont', 'cont needed'));
        $form->addField('titulo', new Eruda_Field('descarga', 'descarga needed'));
        $form->addField('links', new Eruda_Field_AreaArray('links'));
        if($form->validate()){
            $download = $form->getValue();
            $download->set_id($id);
            $download->parseLinks();
            Eruda_Mapper_Anime::update($download);  
            self::uploadImage('imagen', $id, 'capturas_anime', false, 180);
            header( 'Location: /admin/anime/'.$id.'/') ;
            $this->end();
            exit();
        }else if(!$this->_onlyheader) {
                $dir = array(
                    '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                    'anime/' => 'Anime',
                    'anime/new/' => 'Nueva Descarga'
                    );
                $model = new Eruda_Model_Admin($this->user, $dir);
                $download = $form->getValue();
                $model->add_data('series',Eruda_Mapper_Anime::getSeries());
                $model->add_data('descarga',$download);

                $this->header->addCSS('anime.css');
                $view = new Eruda_View_HTML('admin', array('section'=>'animeform'));
                $view->setHeader($this->header);
                return new Eruda_MV($view, $model);
            
        }
        return null;
    }
    
    
    
    function ProyectosList() {   
        $this->header->append2Title('Proyectos');       
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'proyectos/' => 'Proyectos'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $model->add_data('proyectos', Eruda_Mapper_Proyecto::All());
            $model->add_data('proy',new Eruda_Model_Proyecto());
            
            $view = new Eruda_View_HTML('admin', array('section'=>'proyectos'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function ProyectosGet() {        
        $this->header->append2Title('Modificar Proyecto');       
        $id = $this->_params[0];
        $proy = Eruda_Mapper_Proyecto::get($id);
        if($proy==null) {
            return new Eruda_CF('Error', 'E404');
        }
        if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'proyectos/' => 'Proyectos',
                'proyectos/'.$id.'/' => 'Editar'
                );
            
            $model = new Eruda_Model_Admin($this->user, $dir);
            
            $model->add_data('proy',$proy);
            
            $this->header->addCSS('proyecto.css');
            $view = new Eruda_View_HTML('admin', array('section'=>'proyectoform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function ProyectosPut() {   
        $this->header->append2Title('Proyectos');       
        $form = new Eruda_Form('Proyecto');
        $form->addField('serie', new Eruda_Field('serie', 'serie needed'));
        $form->addField('tipo', new Eruda_Field('tipo', 'tipo needed'));
        $form->addField('estado', new Eruda_Field('estado', 'estado needed'));
        $form->addField('texto', new Eruda_Field('texto', 'texto needed'));
        if($form->validate()){
            $proy = $form->getValue();
            Eruda_Mapper_Proyecto::save($proy);  
            if(!($proy->get_id()>0)) {
                return new Eruda_CF('Error', 'E500');
            }
            $id = $proy->get_id(); 
            
            self::uploadImage('imagen', $id, 'capturas_projects', 200);
           
            header( 'Location: /admin/proyectos/'.$id.'/') ;
            $this->end();
            exit();
        }else if(!$this->_onlyheader) {
            $dir = array(
                '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                'proyectos/' => 'Proyectos',
                'proyectos/new/' => 'Nuevo Proyecto'
            );
            $model = new Eruda_Model_Admin($this->user, $dir);
            $proy = $form->getValue();
            
            $model->add_data('proyectos', Eruda_Mapper_Proyecto::All());
            $model->add_data('proy',$proy);

            $this->header->addCSS('proyecto.css');
            $view = new Eruda_View_HTML('admin', array('section'=>'proyectos'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function ProyectosPost() {   
        $this->header->append2Title('Modificar Proyecto');       
        $id = $this->_params[0];
        if(Eruda_Mapper_Proyecto::get($id)==null) {
            return new Eruda_CF('Error', 'E404');
        }
        $form = new Eruda_Form('Proyecto');
        $form->addField('serie', new Eruda_Field('serie', 'serie needed'));
        $form->addField('tipo', new Eruda_Field('tipo', 'tipo needed'));
        $form->addField('estado', new Eruda_Field('estado', 'estado needed'));
        $form->addField('texto', new Eruda_Field('texto', 'texto needed'));
        if($form->validate()){
            $download = $form->getValue();
            $download->set_id($id);
            Eruda_Mapper_Proyecto::update($download);  
            self::uploadImage('imagen', $id, 'capturas_projects', 200);
            header( 'Location: /admin/proyectos/'.$id.'/') ;
            $this->end();
            exit();
        }else if(!$this->_onlyheader) {
                $dir = array(
                    '' => Eruda::getEnvironment()->getTitle(). ' Administración',
                    'proyectos/' => 'Proyectos',
                    'proyectos/'.$id.'/' => 'Editar'
                    );
                $model = new Eruda_Model_Admin($this->user, $dir);
                $proy = $form->getValue();

                $model->add_data('proyectos', Eruda_Mapper_Proyecto::All());
                $model->add_data('proy',$proy);
                
            $this->header->addCSS('proyecto.css');
                $view = new Eruda_View_HTML('admin', array('section'=>'proyectoform'));
                $view->setHeader($this->header);
                return new Eruda_MV($view, $model);
            
        }
        return null;
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
    
    
    static function uploadImage($var, $name, $dest='img', $min_x = false, $min_y = false, $format = 'jpg'){
        if(isset($_FILES[$var])){
            $handle = new upload($_FILES[$var]);
            if ($handle->uploaded) {
                $handle->mime_check             = true;
                //$handle->file_max_size          = '1048576';
                $handle->image_resize           = true;
                $handle->jpeg_quality           = 100;
                if($min_x){
                    $handle->image_x            = $min_x;
                    $handle->image_ratio_y      = true;
                } else if($min_y){
                    $handle->image_y   = $min_y;
                    $handle->image_ratio_x      = true;
                }
                $handle->image_convert          = $format;
                $handle->file_new_name_body = $name;
                $handle->file_overwrite = true;
                $handle->Process(PUB_PATH.$dest.'/');
                if($handle->processed) 
                    return true;
            }
        }
        
        return false;
    }
}

?>