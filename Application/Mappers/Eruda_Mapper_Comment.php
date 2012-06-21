<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Mapper_Comment
 *
 * @author gaixas1
 */
class Eruda_Mapper_Comment {
    public static $_tablea = 'comment';
    
    /**
     *
     * @param Eruda_Model_Comment $comment
     * @return \Eruda_Model_Comment
     */
    static function save(&$comment){
        $attr = array(
            'entry',
            'author_id',
            'valid',
            'text',
            'date',
        );
        $values = array(
            $comment->get_entry_id(),
            $comment->get_author_id(),
            $comment->get_valid(),
            $comment->get_text(),
            'NOW()'
        );
        
        Eruda::getDBConnector()->insertOne(self::$_tablea, $attr, $values);
        $comment->set_id(Eruda::getDBConnector()->lastID());
        return $comment;
    }
    
    /**
     *
     * @param int $id
     * @return Eruda_Model_Entry
     */
    static function get($id){
        $entry = Eruda::getDBConnector()->selectID(self::$_tablea, $id, 'Comment');
        return $entry;
    }
    
    static function getCountFrom($entry){
        $values = array('entry'=>$entry,
            'valid'=>'1');
        $comments = Eruda::getDBConnector()->selectCountValues(self::$_tablea, $values);
        return $comments;
    }
    
    static function getFrom($entry){
        $values = array(
            'entry'=>$entry
            );
        $order = array(array('id','ASC'));
        $comments = Eruda::getDBConnector()->selectMulti(self::$_tablea, $values, $order, 0, 999999, 'Comment');
        return $comments;
    }
    
}

?>
