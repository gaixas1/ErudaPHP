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
                    setUser($user, $mantain);
                    return $user->get_id();
                }
            }
        }
        
        return 0;
    }
    
    /**
     */
    static function LogOut(){
        $_SESSION['Eruda_auth'] = null;
        unset($_SESSION['Eruda_auth']);
    }
    
    /**
     * @return \Eruda_Model_User 
     */
    static function getUser(){
        $user = null;
        if(isset($_SESSION['Eruda_auth']) && is_array($_SESSION['Eruda_auth'])){
            $id = $_SESSION['Eruda_auth']['id'];
            if(is_int($id) && $id>0)
                $user = Eruda_Mapper_User::get($id);
        }
        
        if($user==null && isset($_COOKIE['Eruda_auth']) && isset($_COOKIE['Eruda_session'])){
            $id = Eruda_Mapper_Auth::get($_COOKIE['Eruda_auth'], $_COOKIE['Eruda_session']);
            if(is_int($id) && $id>0)
                $user = Eruda_Mapper_User::get($id);
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
        $_SESSION['Eruda_auth'] = array();
        $_SESSION['Eruda_auth']['id'] = $user->get_id();
        
        if($mantain){
            $auth = self::random_gen(64);
            $session = self::random_gen(64);
            Eruda_Mapper_Auth::set($auth, $session, $user->get_id());
            setcookie('Eruda_auth', $auth, time()+30000000);
            setcookie('Eruda_session', $session, time()+30000000);
        }
    }
    
    /**
     * @param Eruda_Model_User $user 
     */
    static function hashPassword(&$user){
        $pass = $user->get_pass();
        $hasher = new PasswordHash(8, TRUE);
	$pass= $hasher->HashPassword($pass);
        $user->set_pass($pass);
    }
    
    
    /**
     * @param int $len
     * @return string 
     */
    static function random_gen($len){
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890+-*/._#";
        $random = '';
        for($i = 0; $i < $len; $i++)  {    
            $random .= $chars[rand()%(strlen($chars))];  
        }  
        return $random;
    }
}


?>
