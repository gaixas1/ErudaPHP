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
class Eruda_Mapper_Anime {
    public static $_tableA = 'animelinks';
    public static $_tableB = 'animeseries';
    
    public static $capis = array();
    
    /**
     *
     * @param int $id
     * @return \Eruda_Model_Anime 
     */
    static function get($id){
        if(isset(self::$capis[$id])) return self::$capis[$id];
        $cap = Eruda::getDBConnector()->selectID(self::$_tableA, $id, 'Anime');
        if($cap) self::$capis[$cap->get_id()] = $cap;
        return $cap;
    }
    
    
    
    static function getLasts($n){
        $order = array(
            array('id', 'DESC')
        );
        return Eruda::getDBConnector()->selectMulti(self::$_tableA, null, $order, 0, $n, 'Anime');
    }
    
    static function getLastsFromSerie($n, $serie){
        $values = array(
            'serie' => $serie
        );
        $order = array(
            array('id', 'DESC')
        );
        return Eruda::getDBConnector()->selectMulti(self::$_tableA, $values, $order, 0, $n, 'Anime');
    }
    
    static function getSerieCont($serie, $cont){
        $values = array(
            'serie' => $serie,
            'cont' => $cont
        );
        $order = array(
            array('id', 'DESC')
        );
        return Eruda::getDBConnector()->selectMulti(self::$_tableA, $values, $order, 0, 9999, 'Anime');
    }
    
    static function getSeries(){
        $order = array(array('serie','ASC'));
        return Eruda::getDBConnector()->selectAll(self::$_tableB, $order, 0, 99999, 'AnimeSerie');
    }
    
    
    static function getSerie($id){
        $serie = Eruda::getDBConnector()->selectID(self::$_tableB, $id, 'AnimeSerie');
        return $serie;
    }
    static function getSerieByTitle($title){
        $serie = Eruda::getDBConnector()->selectOne(self::$_tableB, array('serie' => $title),0, 'AnimeSerie');
        return $serie;
    }
    
    static function saveSerie(&$serie) {
        $attr = array(
            'serie',
            'cont'
        );
        $values = array(
            $serie->get_serie(),
            implode(',', $serie->get_cont())
        );
        
        Eruda::getDBConnector()->insertOne(self::$_tableB, $attr, $values);
        $serie->set_id(Eruda::getDBConnector()->lastID());
        return $serie;
    }
    
    static function updateSerie($serie) {
        $values = array(
            'serie' => $serie->get_serie(),
            'cont' => implode(',', $serie->get_cont()),
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
     * @param Eruda_Model_Anime $down
     * @return \Eruda_Model_Anime
     */
    static function save(&$down) {
        $attr = array(
            'serie',
            'cont',
            'titulo',
            'downloads'
        );
        $values = array(
            $down->get_serie(),
            $down->get_cont(),
            $down->get_titulo(),
            serialize($down->get_links())
        );
        
        Eruda::getDBConnector()->insertOne(self::$_tableA, $attr, $values);
        $down->set_id(Eruda::getDBConnector()->lastID());
        return $down;
    }
    
    
    /**
     *
     * @param Eruda_Model_Anime $down
     * @return \Eruda_Model_Anime 
     */
    static function update($down) {
        $values = array(
            'serie' =>  $down->get_serie(),
            'cont' => $down->get_cont(),
            'titulo' => $down->get_titulo(),
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
