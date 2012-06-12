<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Mapper_Tag
 *
 * @author gaixas1
 */
class Eruda_Mapper_Tag {
    public static $_tableA = 'tags';
    
    
    static function tagsfromEntry($id){
        $rows = Eruda::getDBConnector()->selectMulti(self::$_tableA, array('entry'=>$id));
        $tagsId = array();
        foreach($rows as $row){
            $tagsId[] = $row['tag'];
        }
        return $tagsId;
    }
}

?>
