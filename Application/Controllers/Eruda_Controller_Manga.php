<?php
/**
 * Description of Eruda_Controller_Manga
 *
 * @author gaixas1
 */
class Eruda_Controller_Manga extends Eruda_Controller {
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
            $this->header->addCSS('manga.css');
            $this->header->addJavascript('jquery.js');
            $this->header->addJavascript('basic.js');
            $this->header->addJavascript('fb.js');
            
            $this->series = Eruda_Mapper_Manga::getSeries();
        }
    }
    
    
    public function end() {    
        Eruda::getDBConnector()->disconnect();
    }
    
    
    
    function index() {        
        if(!$this->_onlyheader) {
            $mangas = Eruda_Mapper_Manga::getLasts(10);
            
            $model = new Eruda_Model_Manganime($this->user, $this->avisos, $this->series, $mangas);
            
            $view = new Eruda_View_HTML('basic', array('section'=>'manganime', 'lateral'=>'lateralmanganime'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function Serie() {        
        if(!$this->_onlyheader) {
            $serie = $this->_params[0];
            $mangas = Eruda_Mapper_Manga::getLastsFromSerie(10,$serie);
            if(!(count($mangas)>0)) {
                return new Eruda_CF('Error', 'E404');
            }
            
            $model = new Eruda_Model_Manganime($this->user, $this->avisos, $this->series, $mangas);
            
            $view = new Eruda_View_HTML('basic', array('section'=>'manganime', 'lateral'=>'lateralmanganime'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function Tomo() {        
        if(!$this->_onlyheader) {
            $serie = $this->_params[0];
            $tomo = $this->_params[1];
            $mangas = Eruda_Mapper_Manga::getSerieTomo($serie, $tomo);
            if(!(count($mangas)>0)) {
                return new Eruda_CF('Error', 'E404');
            }
            
            $model = new Eruda_Model_Manganime($this->user, $this->avisos, $this->series, $mangas);
            
            $view = new Eruda_View_HTML('basic', array('section'=>'manganime', 'lateral'=>'lateralmanganime'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
}

?>
