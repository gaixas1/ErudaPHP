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
    public static $_tableA = 'category';
    public static $_tableB = 'category_view';
    public static $_tableC = 'entry_cat';
    
    public static $cats = array();
    
    /**
     *
     * @param int $id
     * @return Eruda_Model_Category
     */
    static function All(){
        $cats = Eruda::getDBConnector()->selectAll(self::$_tableB, array(array('name','ASC')), 0, 999, 'Category');
        return $cats;
    }
    
    /**
     *
     * @param int $id
     * @return Eruda_Model_Category
     */
    static function get($id){
        if(isset(self::$cats[$id])) return self::$cats[$id];
        
        $cat = Eruda::getDBConnector()->selectID(self::$_tableB, $id, 'Category');
        if($cat) self::$cats[$cat->get_id()] = $cat;
        return $cat;
    }
    
    /**
     *
     * @param string $name
     * @return Eruda_Model_Category
     */
    static function getName($name){
        $cat = Eruda::getDBConnector()->selectOne(self::$_tableB, array('name' => $name), 0, 'Category');
        if($cat) self::$cats[$cat->get_id()] = $cat;
        return $cat;
    }
    
    /**
     *
     * @param string $link
     * @return Eruda_Model_Category
     */
    static function getLink($link){
        $cat = Eruda::getDBConnector()->selectOne(self::$_tableB, array('link' => $link), 0, 'Category');
        if($cat) self::$cats[$cat->get_id()] = $cat;
        return $cat;
    }
    
    static function IdsfromEntry($id){
        $rows = Eruda::getDBConnector()->selectMulti(self::$_tableC, array('entry'=>$id));
        $catsId = array();
        foreach($rows as $row){
            $catsId[] = $row['cat'];
        }
        return $catsId;
    }
    
    /**
     *
     * @param Eruda_Model_User $user
     * @return \Eruda_Model_User 
     */
    static function save(&$cat){
        $attr = array(
            'name',
            'link'
        );
        $values = array(
            $cat->get_name(),
            $cat->get_link()
        );
        
        Eruda::getDBConnector()->insertOne(self::$_tableA, $attr, $values);
        $cat->set_id(Eruda::getDBConnector()->lastID());
        if($cat) self::$cats[$cat->get_id()] = $cat;
        return $cat;
    }
}

?>