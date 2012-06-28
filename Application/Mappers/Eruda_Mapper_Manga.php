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
            'tomos' => implode(',', $serie->get_tomos()),
            'updated' => '0'
        );
        
        Eruda::getDBConnector()->updateID(self::$_tableB, $values, $serie->get_id());
        return $serie;
    }
    
    static function deleteSerie($id) {
        Eruda::getDBConnector()->deleteID(self::$_tableB, $id);
    }
    
    
    
    /**
     *
     * @param Eruda_Model_Manga $down
     * @return \Eruda_Model_Manga 
     */
    static function save(&$down) {
        $attr = array(
            'serie',
            'tomo',
            'titulo',
            'vero',
            'downloads'
        );
        $values = array(
            $down->get_serie(),
            $down->get_tomo(),
            $down->get_titulo(),
            ($down->has_verO())? '1':'0',
            serialize($down->get_links())
        );
        
        Eruda::getDBConnector()->insertOne(self::$_tableA, $attr, $values);
        $down->set_id(Eruda::getDBConnector()->lastID());
        return $down;
    }
    
    
    /**
     *
     * @param Eruda_Model_Manga $down
     * @return \Eruda_Model_Manga 
     */
    static function update($down) {
        $values = array(
            'serie' =>  $down->get_serie(),
            'tomo' => $down->get_tomo(),
            'titulo' => $down->get_titulo(),
            'vero' => ($down->has_verO())? '1':'0',
            'downloads' => serialize($down->get_links()),
            'updated' => '0'
        );
        
        Eruda::getDBConnector()->updateID(self::$_tableA, $values, $down->get_id());
        return $down;
    }
    
    
    static function getNoUpdatedSeries(){
        $order = array(array('id','ASC'));
        $values = array(
            'updated' => '0'
        );
        return Eruda::getDBConnector()->selectMulti(self::$_tableB, $values, $order, 0, 99999);
    }
    static function getNoUpdated(){
        $order = array(array('id','ASC'));
        $values = array(
            'updated' => '0'
        );
        return Eruda::getDBConnector()->selectMulti(self::$_tableA, $values, $order, 0, 99999);
    }
    
    static function setUpdatedSerie($id){
        $values = array(
            'updated' => '1'
        );
        
        Eruda::getDBConnector()->updateID(self::$_tableB, $values, $id);
    }
    static function setUpdated($id){
        $values = array(
            'updated' => '1'
        );
        
        Eruda::getDBConnector()->updateID(self::$_tableA, $values, $id);
    }
}

?>