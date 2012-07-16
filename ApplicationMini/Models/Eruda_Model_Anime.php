<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Model_Anime
 *
 * @author gaixas1
 */
class Eruda_Model_Anime extends Eruda_Model{
    static public $servers = array(
		'mediafire' => 1,
		'fileserve' => 1,
		'badongo' => 1,
		'4shared' => 1,
		'torrent' => 2,
		'nyaa' => 2,
		'frozen-layer' => 2,
		'fileserve' => 1,
		'megaupload' => -1,
		'megarotic' => -1
		);
    static public $URLd = '/download/';
    static public $URLt =  'img/servers/';
    static public $URLc =  'capturas_anime/';
    
    
    
    protected $id;
    protected $serie;
    protected $titulo;
    protected $cont;
    protected $links = array();
    
    public function __construct($vals=null) {
        if(is_array($vals)){
            $this->id = $vals['id'];
            $this->serie = $vals['serie'];
            $this->titulo = $vals['titulo'];
            $this->cont = $vals['cont'];
            $this->links = unserialize($vals['downloads']);
        } else {
            $this->id = 0;
            $this->serie = '';
            $this->titulo = '';
            $this->cont = '';
            $this->links = array();
        }
    }
    
    public function __toString() {
        $serie=str_replace("_", ' ', $this->serie );
        
        $a = '<article class="anime anime_'.str_replace('!','',$this->serie).'">';
        
        $a .= '<header><h1>'.$serie.'</h1><h2>['.$this->cont.'] '.$this->titulo.'</h2></header>';
        
        $a .= '<section class="imagenes">';
        $a .=  '<img src="'.Eruda_Environment::getBaseURL().self::$URLc.$this->id.'.jpg"/> ';
        $a .= '</section>';
        
        $a .= '<footer>';
        
        foreach($this->links as $k => $link) {
            if (isset(self::$servers[$link[0]])) 
                if(self::$servers[$link[0]]==1)
                    $a .=  '<div class="animelink"><a title="Descargar '.$link[0].'" target="_blank" href="'.self::$URLd.'anime/'.$this->id.'/'.$k.'/'.$this->serie."/".$this->titulo.'/"><img class ="donwImage"  alt="Descargar '.$link[0].'" src="'.Eruda_Environment::getBaseURL().self::$URLt.''.$link[0].'.jpg"><span class="dtext"> Descargar '.$link[2].'</span></a></div>';
                else if(self::$servers[$link[0]]==2)
                    $a .=  '<div class="animelink"><a title="Descargar Torrent" target="_blank" href="'.self::$URLd.'anime/'.$this->id.'/'.$k.'/'.$this->serie."/".$this->titulo.'/"><img class ="donwImage"  alt="Descargar Torrent" src="'.Eruda_Environment::getBaseURL().self::$URLt.'torrent.jpg"><span class="dtext"> Descargar Torrent</span></a></div>';
                else
                    $a .=  '<div class="animelinkOff"><img class ="donwImageOff"  alt="Descargar '.$link[0].'" src="'.Eruda_Environment::getBaseURL().self::$URLt.$link[0].'.jpg"><span class="dtext"> Descargar '.$link[2].'</span></div>';
            else
                $a .=  '<div class="animelink"><a title="Descargar '.$link[0].'" target="_blank" href="'.self::$URLd.'anime/'.$this->id.'/'.$k.'/'.$this->serie."/".$this->titulo.'/"><img class ="donwImage" alt="Descargar '.$link[0].'" src="'.Eruda_Environment::getBaseURL().self::$URLt.'default.jpg"><span class="dtext"> Descargar '.$link[2].'</span></a></div>';
        }
        
        $a .= '</footer>';
            
        $a .= '</article>'; 
        return $a;
    }
    
    function get_description() {
        return '['.$this->id.'] '.  Eruda_Helper_Parser::Link2Text($this->serie.' - '.$this->cont.' - '.$this->titulo);
    }
    
    function get_serie() {
        return $this->serie;
    }
    
    function get_cont() {
        return $this->cont;
    }
    
    function get_titulo() {
        return $this->titulo;
    }
    
    function get_links() {
        return $this->links;
    }
    
    function get_downloads() {
        $ret = '';
        foreach($this->links as $link) {
            $ret .= implode(' , ', $link).'
';
        }
        return $ret;
    }
    function get_id(){
        return $this->id;
    }
    
    
    function set_id($val){
        $this->id = $val;
    }
    
    function set_serie($val){
        $this->serie = $val;
    }
    
    function set_titulo($val){
        $this->titulo = $val;
    }
    
    function set_cont($val){
        $this->cont = $val;
    }
    
    function set_links($val){
        $this->links = $val;
    }
    
    function parseLinks(){
        foreach($this->links as $k => $link){
            if(count($link)==1){
                $val = trim($link[0]);
		if(preg_match('|^.*\.torrent$|', $val, $matches)) {
                    $this->links[$k] = array('torrent', $matches[0],'Torrent');
		} else if(preg_match('|https?://(www\.)?([^\.]*)\..*|', $val, $matches)) {
                    if(count($matches)==2)
                        $this->links[$k] = array($matches[1],$matches[0],ucfirst($matches[1]));
                    else
                        $this->links[$k] = array($matches[2],$matches[0],ucfirst($matches[2]));
		}
            } else if(count($link)==2) {
                $this->links[$k] = array($link[0], $link[1],ucfirst($link[0]));
            } else {
                $this->links[$k] = array($link[0], $link[1],$link[2]);
            }
            
        }
    }
}

?>