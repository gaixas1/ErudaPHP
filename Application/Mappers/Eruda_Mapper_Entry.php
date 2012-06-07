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
    public static $_table = 'entry';
    
    /**
     *
     * @param int $id
     * @return Eruda_Model_Entry
     */
    static function get($id){
        $entry = Eruda::getDBConnector()->selectID(self::$_table, $id, 'Entry');
        return $entry;
    }
}

?>
