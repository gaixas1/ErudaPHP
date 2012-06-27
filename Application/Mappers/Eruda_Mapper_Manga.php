<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Mapper_Anime
 *
 * @author gaixas1
 */
class Eruda_Mapper_Manga {
    public static $_tableA = 'mangalinks';
    public static $_tableB = 'mangaseries';
    
    public static $capis = array();
    
    /**
     *
     * @param int $id
     * @return \Eruda_Model_Anime 
     */
    static function get($id){
        if(isset(self::$capis[$id])) return self::$capis[$id];
        $cap = Eruda::getDBConnector()->selectID(self::$_tableA, $id, 'Manga');
        if($cap) self::$capis[$cap->get_id()] = $cap;
        return $cap;
    }
    
    static function getLasts($n){
        $order = array(
            array('id', 'DESC')
        );
        return Eruda::getDBConnector()->selectMulti(self::$_tableA, null, $order, 0, $n, 'Manga');
    }
    
    static function getLastsFromSerie($n, $serie){
        $values = array(
            'serie' => $serie
        );
        $order = array(
            array('id', 'DESC')
        );
        return Eruda::getDBConnector()->selectMulti(self::$_tableA, $values, $order, 0, $n, 'Manga');
    }
    
    static function getSerieTomo($serie, $tomo){
        $values = array(
            'serie' => $serie,
            'tomo' => $tomo
        );
        $order = array(
            array('id', 'DESC')
        );
        return Eruda::getDBConnector()->selectMulti(self::$_tableA, $values, $order, 0, 9999, 'Manga');
    }
    
    static function getSeries(){
        $order = array(array('serie','ASC'));
        return Eruda::getDBConnector()->selectAll(self::$_tableB, $order, 0, 99999, 'MangaSerie');
    }
}

?>