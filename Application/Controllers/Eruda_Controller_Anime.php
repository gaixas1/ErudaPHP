<?php
/**
 * Description of Eruda_Controller_Manga
 *
 * @author gaixas1
 */
class Eruda_Controller_Anime extends Eruda_Controller {
    protected $header;
    protected $series;
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
            $this->header->addCSS('anime.css');
            $this->header->addJavascript('jquery.js');
            $this->header->addJavascript('basic.js');
            $this->header->addJavascript('fb.js');
            
            $this->series = Eruda_Mapper_Anime::getSeries();
        }
    }
    
    
    public function end() {    
        Eruda::getDBConnector()->disconnect();
    }
    
    
    
    function index() {        
        if(!$this->_onlyheader) {
            $animes = Eruda_Mapper_Anime::getLasts(10);
            
            $model = new Eruda_Model_Manganime($this->user, $this->avisos, $this->series, $animes);
            
            $view = new Eruda_View_HTML($this->device.'basic', array('section'=>'manganime', 'lateral'=>'lateralmanganime'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function Serie() {        
        if(!$this->_onlyheader) {
            $serie = $this->_params[0];
            $animes = Eruda_Mapper_Anime::getLastsFromSerie(10,$serie);
            if(!(count($animes)>0)) {
                return new Eruda_CF('Error', 'E404');
            }
            
            $model = new Eruda_Model_Manganime($this->user, $this->avisos, $this->series, $animes);
            
            $view = new Eruda_View_HTML($this->device.'basic', array('section'=>'manganime', 'lateral'=>'lateralmanganime'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function Contenedor() {        
        if(!$this->_onlyheader) {
            $serie = $this->_params[0];
            $cont = $this->_params[1];
            $animes = Eruda_Mapper_Anime::getSerieCont($serie, $cont);
            if(!(count($animes)>0)) {
                return new Eruda_CF('Error', 'E404');
            }
            
            $model = new Eruda_Model_Manganime($this->user, $this->avisos, $this->series, $animes);
            
            $view = new Eruda_View_HTML($this->device.'basic', array('section'=>'manganime', 'lateral'=>'lateralmanganime'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
}

?>