<?php
/**
 * Description of Eruda_Mapper_User
 *
 * @author gaixas1
 */


/**
 * @property string $_table
 */
class Eruda_Mapper_User {
    public static $_table = 'user';
    
    public static $users = array();
    
    /**
     * @param int $id
     * @return \Eruda_Model_User 
     */
    static function get($id){
        if(isset(self::$users[$id])) return self::$users[$id];
        
        $user = Eruda::getDBConnector()->selectID(self::$_table, $id, 'User');
        if($user) self::$users[$user->get_id()] = $user;
        return $user;
    }
    
    /**
     * @param string $name
     * @return \Eruda_Model_User 
     */
    static function getName($name){
        $user = Eruda::getDBConnector()->selectOne(self::$_table, array('name' => $name), 0, 'User');
        if($user) self::$users[$user->get_id()] = $user;
        return $user;
    }
    
    /**
     * @param string $mail
     * @return \Eruda_Model_User 
     */
    static function getMail($mail){
        $user = Eruda::getDBConnector()->selectOne(self::$_table, array('mail' => $mail), 0, 'User');
        if($user) self::$users[$user->get_id()] = $user;
        return $user;
    }
    
    /**
     *
     * @param Eruda_Model_User $user
     * @return \Eruda_Model_User 
     */
    static function save(&$user){
        $attr = array(
            'name',
            'pass',
            'mail',
            'level',
            'registered',
            'lastlog'
        );
        $values = array(
            $user->get_name(),
            $user->get_pass(),
            $user->get_mail(),
            1,
            'NOW()',
            'NOW()'
        );
        
        Eruda::getDBConnector()->insertOne(self::$_table, $attr, $values);
        $user->set_id(Eruda::getDBConnector()->lastID());
        if($user) self::$users[$user->get_id()] = $user;
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
            'mail' => $user->get_mail(),
            'level' => $user->get_level(),
            'lastlog' => 'NOW()'
        );
        
        Eruda::getDBConnector()->updateID(self::$_table, $values, $user->get_id());
        return $user;
    }
    /**
     *
     * @param Eruda_Model_User $user
     * @return \Eruda_Model_User 
     */
    static function updatePass(&$user, $pass){
        $values = array(
            'pass' => $pass,
            'lastlog' => 'NOW()'
        );
        
        Eruda::getDBConnector()->updateID(self::$_table, $values, $user->get_id());
        $user->set_pass($pass);
        return $user;
    }
    
}

?>
