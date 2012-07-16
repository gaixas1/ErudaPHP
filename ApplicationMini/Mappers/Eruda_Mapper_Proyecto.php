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
class Eruda_Mapper_Proyecto {
    public static $_tableA = 'proyectos';
    public static $_tableB = 'proyectosmini';
    
    public static $list = array();
    
    /**
     *
     * @param int $id
     * @return \Eruda_Model_Proyecto 
     */
    static function get($id){
        if(isset(self::$list[$id])) return self::$list[$id];
        $val = Eruda::getDBConnector()->selectID(self::$_tableA, $id, 'Proyecto');
        if($val) self::$list[$val->get_id()] = $val;
        return $val;
    }
    
    /**
     *
     * @param int $id
     * @return \array(Eruda_Model_Proyecto )
     */
    static function getAll(){
        $res = Eruda::getDBConnector()->selectType(self::$_tableA, 'Proyecto', true);
        foreach($res as $p){
            if($p) self::$list[$p->get_id()] = $p;
        }
        return $res;
    }
    /**
     *
     * @param int $id
     * @return array(Eruda_Model_Proyecto)
     */
    static function All(){
        $proys = Eruda::getDBConnector()->selectAll(self::$_tableB, array(array('serie','ASC')), 0, 999, 'Proyecto');
        return $proys;
    }
    
    
    /**
     *
     * @param Eruda_Model_Proyecto $proy
     * @return Eruda_Model_Proyecto
     */
    static function save(&$proy) {
        $attr = array(
            'serie',
            'tipo',
            'estado',
            'texto'
        );
        $values = array(
            $proy->get_serie(),
            $proy->get_tipo(),
            $proy->get_estado(),
            $proy->get_texto()
        );
        
        Eruda::getDBConnector()->insertOne(self::$_tableA, $attr, $values);
        $proy->set_id(Eruda::getDBConnector()->lastID());
        return $proy;
    }
    
    
    /**
     *
     * @param Eruda_Model_Proyecto $down
     * @return Eruda_Model_Proyecto 
     */
    static function update($proy) {
        $values = array(
            'serie' =>  $proy->get_serie(),
            'tipo' => $proy->get_tipo(),
            'estado' => $proy->get_estado(),
            'texto' => $proy->get_texto()
        );
        
        Eruda::getDBConnector()->updateID(self::$_tableA, $values, $proy->get_id());
        return $proy;
    }
}

?>