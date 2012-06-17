<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Mapper_Aviso
 *
 * @author gaixas1
 */
class Eruda_Mapper_Aviso {
    public static $_tablea = 'aviso';
    
    
    /**
     *
     * @param int $id
     * @return Eruda_Model_Aviso
     */
    static function get($id){
        $entry = Eruda::getDBConnector()->selectID(self::$_tablea, $id, 'Aviso');
        return $entry;
    }
    
    /**
     *
     * @param int $id
     * @return Eruda_Model_Aviso
     */
    static function getLast($n){
        $order = array(array('id','DESC'));
        $avisos = Eruda::getDBConnector()->selectAll(self::$_tablea, $order, 0, $n, 'Aviso');
        return $avisos;
    }
}

?>
