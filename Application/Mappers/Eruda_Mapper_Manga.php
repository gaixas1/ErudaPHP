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
    
    
    static function getSerie($id){
        $serie = Eruda::getDBConnector()->selectID(self::$_tableB, $id, 'MangaSerie');
        return $serie;
    }
    static function getSerieByTitle($title){
        $serie = Eruda::getDBConnector()->selectOne(self::$_tableB, array('serie' => $title), 0, 'MangaSerie');
        return $serie;
    }
    
    static function saveSerie(&$serie) {
        $attr = array(
            'serie',
            'tomos'
        );
        $values = array(
            $serie->get_serie(),
            implode(',', $serie->get_tomos())
        );
        
        Eruda::getDBConnector()->insertOne(self::$_tableB, $attr, $values);
        $serie->set_id(Eruda::getDBConnector()->lastID());
        return $serie;
    }
    
    static function updateSerie($serie) {
        $values = array(
            'serie' => $serie->get_serie(),
            'tomos' => implode(',', $serie->get_tomos())
        );
        
        Eruda::getDBConnector()->updateID(self::$_tableB, $values, $serie->get_id());
        return $serie;
    }
    
    static function deleteSerie($id) {
        Eruda::getDBConnector()->deleteID(self::$_tableB, $id);
    }
}

?>