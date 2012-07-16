<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Helper_Auth
 *
 * @author gaixas1
 */
class Eruda_Helper_Auth {
    
    /**
     * @param string $name
     * @param string $pass
     * @param bool $mantain
     * @return int 
     */
    static function LogIn($name, $pass, $mantain = false){
        if(is_string($name) && is_string($pass)){
            if($user = Eruda_Mapper_User::getName($name)){
                $uspass = $user->get_pass();
                $hasher = new PasswordHash(8, TRUE);
                if($hasher->CheckPassword($pass, $uspass)){
                    self::setUser($user, $mantain);
                    return $user->get_id();
                }
            }
        }
        
        return 0;
    }
    
    static function checkPass($user, $pass){
        $uspass = $user->get_pass();
        $hasher = new PasswordHash(8, TRUE);
        if($hasher->CheckPassword($pass, $uspass)){
            return true;
        }
        return false;
    }
    
    /**
     */
    static function LogOut(){
        $_SESSION['Eruda_auth'] = null;
        unset($_SESSION['Eruda_auth']);
        
        if(isset($_COOKIE['Eruda_auth']) && isset($_COOKIE['Eruda_session'])){
            $auth = $_COOKIE['Eruda_auth'];
            $session = $_COOKIE['Eruda_session'];
            Eruda_Mapper_Auth::del($auth, $session);
            setcookie('Eruda_auth', $auth, time()-3600, '/');
            setcookie('Eruda_session', $session, time()-3600, '/');
        }
    }
    
    /**
     * @return \Eruda_Model_User 
     */
    static function getUser(){
        $user = null;
        if(isset($_SESSION['Eruda_auth']) && is_array($_SESSION['Eruda_auth'])){
            $id = $_SESSION['Eruda_auth']['id'];
            if(is_numeric($id) && $id>0){
                $user = Eruda_Mapper_User::get($id);
            }
        }
        
        if($user==null && isset($_COOKIE['Eruda_auth']) && isset($_COOKIE['Eruda_session'])){
            $id = Eruda_Mapper_Auth::get($_COOKIE['Eruda_auth'], $_COOKIE['Eruda_session']);
            if(is_numeric($id) && $id>0)
                $user = Eruda_Mapper_User::get($id);
        }
        
        if($user==null) {
            $facebook = new Facebook(array(
            'appId'  => '349147981823451',
            'secret' => '2eba833898f95a4d0336b36db64024d6',
            'cookie' => true
            ));

            $userId = $facebook->getUser();

            if ($userId) { 
                try{
                    $userInfo = $facebook->api('/me');
                    
                    $user = Eruda_Mapper_User::getFb($userId);
                    
                    if($user==null) {
                        $user = Eruda_Mapper_User::getMail($userInfo['email']);
                        if($user!=null) {
                            Eruda_Mapper_User::setFb($user, $userId);
                        }
                    }
                    
                    if($user==null) {
                        $uname = $userInfo['username'];
                        $user = Eruda_Mapper_User::getName($uname);
                        if($user==null) {
                            $user = new Eruda_Model_User();
                            $user->set_name($uname);
                            $user->set_mail($userInfo['email']);
                            $user->set_pass(self::random_gen(60));
                            Eruda_Mapper_User::save($user);
                            Eruda_Mapper_User::setFb($user, $userId);
                        } else {
                            $i = 0;
                            do {
                                $i++;
                            } while(($user = Eruda_Mapper_User::getName($uname.'_'.$i))!=null);
                            $user = new Eruda_Model_User();
                            $user->set_name($uname.'_'.$i);
                            $user->set_mail($userInfo['email']);
                            $user->set_pass(self::random_gen(60));
                            Eruda_Mapper_User::save($user);
                            Eruda_Mapper_User::setFb($user, $userId);
                        }
                    }
                }  catch (Exception $e) {
                }    
            }
        }
        
        if($user!=null) {
            self::setUser($user);
        } else{
            $user = new Eruda_Model_User();
            $user->set_id(0);
            $user->set_level(0);
        }
        
        return $user;
    }
    
    /**
     * @param Eruda_Model_User $user 
     */
    static function setUser($user, $mantain = false){
        Eruda_Mapper_User::Log($user);
        $_SESSION['Eruda_auth'] = array();
        $_SESSION['Eruda_auth']['id'] = $user->get_id();
        
        if($mantain){
            $auth = self::random_gen(64);
            $session = self::random_gen(64);
            Eruda_Mapper_Auth::set($auth, $session, $user->get_id());
            setcookie('Eruda_auth', $auth, time()+30000000, '/');
            setcookie('Eruda_session', $session, time()+30000000, '/');
        }
    }
    
    /**
     * @param Eruda_Model_User $user 
     */
    static function hashPassword($pass){
        $hasher = new PasswordHash(8, TRUE);
	$pass= $hasher->HashPassword($pass);
        return $pass;
    }
    
    /**
     * @param Eruda_Model_User $user 
     */
    static function canAdmin($user){
        return $user->get_level()>=7;
    }
    
    /**
     * @param Eruda_Model_User $user 
     */
    static function validComments($user){
        return $user->get_level()>=3;
    }
    
    
    /**
     * @param int $len
     * @return string 
     */
    static function random_gen($len){
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890+-*/._";
        $random = '';
        for($i = 0; $i < $len; $i++)  {    
            $random .= $chars[rand()%(strlen($chars))];  
        }  
        return $random;
    }
}


?>