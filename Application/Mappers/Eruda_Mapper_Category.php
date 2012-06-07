<?php
/**
 * Description of Eruda_Mapper_Category
 *
 * @author gaixas1
 */

/**
 * @property string $_table
 */
class Eruda_Mapper_Category {
    public static $_table = 'category_view';
    
    public static $cats = array();
    
    /**
     *
     * @param int $id
     * @return Eruda_Model_Category
     */
    static function get($id){
        if(isset(self::$cats[$id])) return self::$cats[$id];
        
        $cat = Eruda::getDBConnector()->selectID(self::$_table, $id, 'Category');
        self::$cats[$cat->get_id()] = $cat;
        return $cat;
    }
}

?>
