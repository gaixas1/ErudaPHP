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
            if(Eruda_Environment::isMobile()) {
                $this->device='mobile_';
            }else{
                $this->device='';
                $this->avisos = Eruda_Mapper_Aviso::getLast(3);
            }
            $this->header = new Eruda_Header_HTML();
            $this->header->setType('HTML5');
            $this->header->setMetatag('Description', 'FallenSoulFansub, todos nuestros mangas on-line para tu disfrute.');
            $this->header->append2Title(Eruda_Environment::getTitle());
            $this->header->addCSS($this->device.'style.css');
            $this->header->addCSS('anime.css');
            $this->header->addJavascript('jquery.js');
            $this->header->addJavascript('basic.js');
            if($this->user->get_id()>0)
                $this->header->addJavascript('fb_connected.js');
            else
                $this->header->addJavascript('fb_disconnected.js');
            
            $this->series = Eruda_Mapper_Anime::getSeries();
        }
    }
    
    
    public function end() {    
        Eruda::getDBConnector()->disconnect();
    }
    
    
    
    function index() {        
        $this->header->prepend2Title('Anime');       
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
        $serie = $this->_params[0];
        $this->header->prepend2Title('Anime');               
        if(!$this->_onlyheader) {
            $animes = Eruda_Mapper_Anime::getLastsFromSerie(10,$serie);
            if(!(count($animes)>0)) {
                return new Eruda_CF('Error', 'E404');
            }
            
            $this->header->prepend2Title(ucfirst(Eruda_Helper_Parser::Link2Text($animes[0]->get_serie())).' '.strtoupper($cont)); 
            
            $model = new Eruda_Model_Manganime($this->user, $this->avisos, $this->series, $animes);
            
            $view = new Eruda_View_HTML($this->device.'basic', array('section'=>'manganime', 'lateral'=>'lateralmanganime'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function Contenedor() { 
        $serie = $this->_params[0];
        $cont = $this->_params[1];
        $this->header->prepend2Title('Anime');                
        if(!$this->_onlyheader) {
            $animes = Eruda_Mapper_Anime::getSerieCont($serie, $cont);
            if(!(count($animes)>0)) {
                return new Eruda_CF('Error', 'E404');
            }
            $this->header->prepend2Title(ucfirst(Eruda_Helper_Parser::Link2Text($animes[0]->get_serie())).' '.strtoupper($cont)); 
            
            $model = new Eruda_Model_Manganime($this->user, $this->avisos, $this->series, $animes);
            
            $view = new Eruda_View_HTML($this->device.'basic', array('section'=>'manganime', 'lateral'=>'lateralmanganime'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function Download() {        
        $id = $this->_params[0];
        $d = $this->_params[1];
        
        $down = Eruda_Mapper_Anime::get($id);
        if($down!=null) {
            $links = $down->get_links();
            if(isset($links[$d])){
                header( 'Location: '.$links[$d][1]) ;
                $this->end();
                exit();
            }
        }
        return new Eruda_CF('Error', 'E404');
    }
}

?>