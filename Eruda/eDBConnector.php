<?php
/**
 * Description of eDBConnector
 * Eruda DataBase Connector
 * ABSTRACT CLASS
 *
 * @author gaixas1
 */
abstract class eDBConnector {
    abstract function connect();
    abstract function disconnect();
    
/* Insert functions*/
    abstract function insertOne($table, $attr, $values);
    abstract function insertMulti($table, $attr, $values);
    
    
/* update functions*/
    abstract function update($table, $values, $where = null);
    abstract function updateID($table, $values, $id);
    abstract function updateVal($table, $values, $where = null);
    
/* delete functions*/
    abstract function delete($table, $where);
    abstract function deleteID($table, $id);
    abstract function deleteVal($table, $attr, $val);
    
/* Select functions*/
    abstract function lastID();
    abstract function selectID($table, $id, $object=null);
    abstract function selectOne($table, $values=array(), $start=0, $object=null);
    abstract function selectAll($table, $order=null, $start=0, $total = 999999, $object=null);
    abstract function selectType($table, $object=null, $random = false);
    abstract function selectMulti($table, $values=array(), $order=null, $start=0, $total = 999999, $object=null);
    abstract function selectCount($table, $group=null, $order=null);
    abstract function selectCountValues($table, $values = array());
}
?>