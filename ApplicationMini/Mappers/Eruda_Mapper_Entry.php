<?php
/**
 * Description of Eruda_Mapper_Entry
 *
 * @author gaixas1
 */


class Eruda_Mapper_Entry {
    public static $_tablea = 'entry';
    public static $_tableb = 'entry_from_cat';  
    public static $_tablec = 'archives';    
    public static $_tabled = 'minientry';    
    
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
        $entries = Eruda::getDBConnector()->selectMulti(self::$_tablea, $values, $order, $start, $total, 'Entry');
        return $entries;
    }
    
    static function countFromAll(){
        return Eruda::getDBConnector()->selectCount(self::$_tablea);
    }
    
    static function getFromCat($cat, $start, $total){
        $values = array('cat'=> $cat);
        $order = array(array('id','DESC'));
        return Eruda::getDBConnector()->selectMulti(self::$_tableb, $values, $order, $start, $total, 'Entry');
    }
    
    static function getFromArchive($month, $year){
        $values = array(
            'year(created)'=> $year,
            'month(created)'=> $month
        );
        $order = array(array('id','DESC'));
        return Eruda::getDBConnector()->selectMulti(self::$_tablea, $values, $order, 0, 100, 'Entry');
    }
    
    static function getArchive(){
        return Eruda::getDBConnector()->selectAll(self::$_tablec, array(array('year','ASC'), array('month', 'ASC')));
    }
    
    static function All(){
        return Eruda::getDBConnector()->selectType(self::$_tabled,'Entry');
    }
    static function Mini($i,$n){
        $order = array(array('id','DESC'));
        return Eruda::getDBConnector()->selectAll(self::$_tabled, $order, $i, $n, 'Entry');
    }
    
    
    
    
    /**
     *
     * @param Eruda_Model_Entry $entry
     * @return \Eruda_Model_Entry
     */
    static function save(&$entry){
        $attr = array(
            'title',
            'text',
            'author_id',
            'created',
            'lastmod'
        );
        $values = array(
            $entry->get_title(),
            $entry->get_text(),
            $entry->get_author_id(),
            'NOW()',
            'NOW()'
        );
        
        Eruda::getDBConnector()->insertOne(self::$_tablea, $attr, $values);
        $entry->set_id(Eruda::getDBConnector()->lastID());
        return $entry;
    }
    /**
     *
     * @param Eruda_Model_Entry $entry
     * @return \Eruda_Model_Entry
     */
    static function update(&$entry){
        $values = array(
            'title' => $entry->get_title(),
            'text' => $entry->get_text(),
            'lastmod'=> 'NOW()'
        );
        
        Eruda::getDBConnector()->updateID(self::$_tablea, $values, $entry->get_id());
        return $entry;
    }
}

?>