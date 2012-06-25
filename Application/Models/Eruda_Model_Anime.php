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
    static public $URLt =  '/img/servers/';
    static public $URLc =  '/capturas_anime/';
    
    
    
    protected $id;
    protected $serie;
    protected $titulo;
    protected $cont;
    protected $links = array();
    
    public function __construct($vals) {
        $this->id = $vals['id'];
        $this->serie = $vals['serie'];
        $this->titulo = $vals['titulo'];
        $this->cont = $vals['cont'];
        $this->links = unserialize($vals['downloads']);
    }
    
    public function __toString() {
        $serie=str_replace("_", ' ', $this->serie );
        
        $a = '<article class="anime anime_'.str_replace('!','',$this->serie).'">';
        
        $a .= '<header><h1>'.$serie.'</h1><h2>['.$this->cont.'] '.$this->titulo.'</h2></header>';
        
        $a .= '<section class="imagenes">';
        $a .=  '<img src="'.self::$URLc.$this->id.'.jpg"/> ';
        $a .= '</section>';
        
        $a .= '<footer>';
        
        foreach($this->links as $k => $link) {
            if (isset(self::$servers[$link[0]])) 
                if(self::$servers[$link[0]]==1)
                    $a .=  '<div class="animelink"><a title="Descargar '.$link[0].'" target="_blank" href="'.self::$URLd.'anime/'.$this->id.'/'.$k.'/'.$this->serie."/".$this->titulo.'/"><img class ="donwImage"  alt="Descargar '.$link[0].'" src="'.self::$URLt.''.$link[0].'.jpg"><span class="dtext"> Descargar '.$link[2].'</span></a></div>';
                else if($servers[$link[0]]==2)
                    $a .=  '<div class="animelink"><a title="Descargar Torrent" target="_blank" href="'.self::$URLd.'anime/'.$this->id.'/'.$k.'/'.$this->serie."/".$this->titulo.'/"><img class ="donwImage"  alt="Descargar Torrent" src="'.self::$URLt.'torrent.jpg"><span class="dtext"> Descargar Torrent</span></a></div>';
                else
                    $a .=  '<div class="animelinkOff"><img class ="donwImageOff"  alt="Descargar '.$link[0].'" src="'.self::$URLt.$link[0].'.jpg"><span class="dtext"> Descargar '.$link[2].'</span></div>';
            else
                $a .=  '<div class="animelink"><a title="Descargar '.$link[0].'" target="_blank" href="'.self::$URLd.'anime/'.$this->id.'/'.$k.'/'.$this->serie."/".$this->titulo.'/"><img class ="donwImage" alt="Descargar '.$link[0].'" src="'.self::$URLt.'default.jpg"><span class="dtext"> Descargar '.$link[2].'</span></a></div>';
        }
        
        $a .= '</footer>';
            
        $a .= '</article>'; 
        return $a;
    }
    
    
    function get_id(){
        return $this->id;
    }
}

?>