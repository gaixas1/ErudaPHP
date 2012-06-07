<?php
/**
 * Description of Eruda_Mapper_User
 *
 * @author gaixas1
 */


/**
 * @property Eruda_DBConnector_MYSQLi $_connector
 * @property string $_table
 */
class Eruda_Mapper_User extends Eruda_Mapper{
    public static $_table = 'user';
    
    public static $users = array();
    
    /**
     *
     * @param int $id
     * @return \Eruda_Model_User 
     */
    static function get($id){
        if(isset(self::$users[$id])) return self::$users[$id];
        
        $user = Eruda_Core::getDBConnector()->selectID(self::$_table, $id, 'User');
        self::$users[$user->get_id()] = $user;
        return $user;
    }
    
    /**
     *
     * @param Eruda_Model_User $user
     * @return \Eruda_Model_User 
     */
    static function save($user){
        $attr = array(
            'name',
            'pass',
            'mail'
        );
        $values = array(
            $user->get_name(),
            $user->get_pass(),
            $user->get_mail()
        );
        
        Eruda_Core::getDBConnector()->insertOne(self::$_table, $attr, $values);
        $user->set_id(Eruda_Core::getDBConnector()->lastID());
        self::$users[$user->get_id()] = $user;
        return $user;
    }
    
    /**
     *
     * @param Eruda_Model_User $user
     * @return \Eruda_Model_User 
     */
    static function update($user){
        $values = array(
            'pass' => $user->get_pass(),
            'mail' => $user->get_mail()
        );
        
        Eruda_Core::getDBConnector()->updateID(self::$_table, $values, $user->get_id());
        return $user;
    }
    
}

?>
