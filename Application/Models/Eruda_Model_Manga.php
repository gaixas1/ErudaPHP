<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Model_Manga
 *
 * @author gaixas1
 */
class Eruda_Model_Manga extends Eruda_Model {
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
    static public $URLt =  '/img/servers/';
    static public $URLc =  '/capturas_manga/';
    static public $VERONLINE =  'http://veronline.fallensoul.es/';
    
    protected $id;
    protected $serie;
    protected $tomo;
    protected $titulo;
    protected $links = array();
    protected $verO = false;
    
    public function __construct($vals=null) {
        if(is_array($vals)){
            $this->id = $vals['id'];
            $this->serie = $vals['serie'];
            $this->titulo = $vals['titulo'];
            $this->tomo = $vals['tomo'];
            $this->verO = $vals['vero'];
            $this->links = unserialize($vals['downloads']);
        } else {
            $this->id = 0;
            $this->serie = '';
            $this->titulo = '';
            $this->tomo = '';
            $this->verO = false;
            $this->links = array();
        }
    }
    
    public function __toString() {
        $serie=str_replace("_", ' ', $this->serie );
        $a = '<article class="manga manga_'.$this->serie.'">';
        
        if(($this->serie == 'One_Shots')||($this->serie == 'Hentai'))
            $a .= '<header><h1>'.$serie.'</h1><h2>'.str_replace('_', ' ', $this->tomo).'</h2></header>';
        else
            $a .= '<header><h1>'.$serie.'</h1><h2>Tomo '.$this->tomo.' - '.$this->titulo.'</h2></header>';
        
        $a .= '<section class="imagenes">';
        if($this->verO)
            $a .=  '<img src="'.self::$URLc.$this->id.'a.jpg"/> <img src="'.self::$URLc.$this->id.'b.jpg"/>';
        else
            $a .=  '<img src="'.self::$URLc.$this->id.'a.jpg"/>';
        $a .= '</section>';
            
        $a .= '<footer>';
        
        if($this->verO)
            $a .=  '<a title="Ver online" target="_blank" href="'.self::$VERONLINE.'ver.php?pg='.$this->serie.'/'.$this->tomo.'/'.$this->titulo.'"><img class ="donwImage"  alt="Ver online" src="'.self::$URLt.'ver.jpg"></a>';
            
        foreach($this->links as $k => $link) {
            if (isset(self::$servers[$link[0]])) 
                if(self::$servers[$link[0]]==1)
                    $a .=  '<a title="Descargar '.$link[0].'" target="_blank" href="'.self::$URLd.'manga/'.$this->id.'/'.$k.'/'.$this->serie."/".$this->tomo.'/"><img class ="donwImage"  alt="Descargar '.$link[0].'" src="'.self::$URLt.$link[0].'.jpg"></a>';
                else if(self::$servers[$link[0]]==2)
                    $a .=  '<a title="Descargar Torrent" target="_blank" href="'.self::$URLd.'manga/'.$this->id.'/'.$k.'/'.$this->serie."/".$this->tomo.'/"><img class ="donwImage"  alt="Descargar Torrent" src="'.self::$URLt.'torrent.jpg"></a>';
                else
                    $a .=  '<img class ="donwImageOff"  alt="Descargar '.$link[0].'" src="'.self::$URLt.$link[0].'.jpg">';
            else
                $a .=  '<a title="Descargar '.$link[0].'" target="_blank" href="'.self::$URLd.'manga/'.$this->id.'/'.$k.'/'.$this->serie."/".$this->tomo.'/"><img class ="donwImage" alt="Descargar '.$link[0].'" src="'.self::$URLt.'default.jpg"></a>';
        }
            
        $a .= '</footer>';
            
        $a .= '</article>'; 
            return $a;
    }
    
    function get_description() {
        return '['.$this->id.'] '.$this->serie.' - '.$this->tomo.' - '.$this->titulo;
    }
    
    function get_serie() {
        return $this->serie;
    }
    
    function get_tomo() {
        return $this->tomo;
    }
    
    function get_titulo() {
        return $this->titulo;
    }
    
    function get_links() {
        return $this->links;
    }
    
    function get_downloads() {
        foreach($this->links as $link) {
            $ret .= implode(' , ', $link).'
';
        }
        return $ret;
    }
    
    function has_verO() {
        return ($this->verO != null)&&($this->verO != false);
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
    
    function set_tomo($val){
        $this->tomo = $val;
    }
    
    function set_verO($val){
        $this->verO = ($val != null)&&($val != false)&&($val != 0);
    }
    
    function set_links($val){
        $this->links = $val;
    }
    
    function parseLinks(){
        foreach($this->links as $k => $link){
            if(count($link)==1){
                $val = trim($link[0]);
		if(preg_match('|^.*\.torrent$|', $val, $matches)) {
                    $this->links[$k] = array('torrent', $matches[0]);
		} else if(preg_match('|https?://(www\.)?([^\.]*)|', $val, $matches)) {
                    if(count($matches)==2)
                        $this->links[$k] = array($matches[1],$matches[0]);
                    else
                        $this->links[$k] = array($matches[2],$matches[0]);
		}
            } else {
                $this->links[$k] = array($link[0], $link[1]);
            }
        }
    }
}

?>