<?php
/**
 * Description of eEnvironment
 * Eruda Environment
 * AppClass for App environment variables
 * STATIC CLASS
 *
 * @author gaixas1
 */
class eEnvironment {
    static $title;
    static $base;
    static $mail;
    
    static function init(
            $title,
            $base,
            $mail){
                self::$title = $title;
                self::$base = $base;
                self::$mail = $mail;
            }
    
/**
* * Getters & Setters
**/
    static function get_title(){
        return self::$title;
    }
    static function set_title($var){
        return self::$title = $var;
    }
    
    static function get_base(){
        return self::$base;
    }
    static function set_base($var){
        return self::$base = $var;
    }
    
    static function get_mail(){
        return self::$mail;
    }
    static function set_mail($var){
        return self::$mail = $var;
    }
}
?>
