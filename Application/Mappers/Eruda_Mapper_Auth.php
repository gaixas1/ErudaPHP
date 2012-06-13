<?php
/**
 * Description of Eruda_Mapper_User
 *
 * @author gaixas1
 */


/**
 * @property string $_table
 */
class Eruda_Mapper_Auth {
    public static $_table = 'usersession';
    
    /**
     * @param int $id
     * @return \Eruda_Model_User 
     */
    static function get($auth, $session){
        $values = array(
            'idauth' => $auth,
            'idsession' => $session
        );
        $session = Eruda::getDBConnector()->selectOne(self::$_table, $values);
        if($session!=null && is_array($session)){
            return $session['iduser'];
        }
        return 0;
    }
    
    /**
     *
     * @param string $auth
     * @param string $session
     * @param int $user 
     */
    static function set($auth, $session, $userId){
        $attr = array(
            'idauth',
            'idsession',
            'iduser'
        );
        $values = array(
            $auth,
            $session,
            $userId
        );
        $session = Eruda::getDBConnector()->insertOne(self::$_table, $attr, $values);
    }
    
    /**
     *
     * @param string $auth
     * @param string $session
     */
    static function del($auth, $session){
        $values = array(
            'idauth' => $auth,
            'idsession' => $session
        );
        Eruda::getDBConnector()->deleteVals(self::$_table, $values);
    }
}

?>
