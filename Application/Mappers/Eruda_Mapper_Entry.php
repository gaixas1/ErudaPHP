<?php
/**
 * Description of Eruda_Mapper_Entry
 *
 * @author gaixas1
 */


/**
 * @property string $_table
 */
class Eruda_Mapper_Entry {
    public static $_tablea = 'entry';
    public static $_tableb = 'entry_from_cat';    
    
    /**
     *
     * @param int $id
     * @return Eruda_Model_Entry
     */
    static function get($id){
        $entry = Eruda::getDBConnector()->selectID(self::$_tablea, $id, 'Entry');
        return $entry;
    }
    
    static function getFromAll($start, $total){
        $values = array();
        $order = array(array('id','DESC'));
        return Eruda::getDBConnector()->selectMulti(self::$_tablea, $values, $order, $start, $total, 'Entry');
    }
    
    static function getFromCat($cat, $start, $total){
        $values = array('cat'=> $cat);
        $order = array(array('id','DESC'));
        return Eruda::getDBConnector()->selectMulti(self::$_tableb, $values, $order, $start, $total, 'Entry');
    }
}

?>
