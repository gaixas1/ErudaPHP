<?php
/**
 * Description of Eruda_DBConnector
 *
 * @author gaixas1
 */

abstract class  Eruda_DBConnector {
    
    /**
     * @return \Eruda_DBConnector
     */
    abstract function connect();
    
    /**
     * @return \Eruda_DBConnector
     */
    abstract function disconnect();
    
    /**
     * @param string $table
     * @param array $attr
     * @param array $values
     * @return boolean 
     */
    abstract function insertOne($table, $attr, $values);
    
    /**
     * @param string $table
     * @param array $attr
     * @param array $values
     * @return boolean 
     */
    abstract function insertMulti($table, $attr, $values);
    
    /**
     * @return int 
     */
    abstract function lastID();
    
    /**
     * @param string $table
     * @param array $values
     * @param string $where
     * @return int
     */
    abstract function update($table, $values, $where);
    
    /**
     * @param string $table
     * @param array $values
     * @param string $id
     * @return int
     */
    abstract function updateID($table, $values, $id);
    
    
    /**
     * @param string $table
     * @param array $values
     * @param string $where
     * @param string $val
     * @return int
     */
    abstract function updateVal($table, $values, $where);
    
    /**
     * @param string $table
     * @param string $where
     * @return int 
     */
    abstract function delete($table, $where);
    
    /**
     * @param string $table
     * @param int|string $id
     * @return int 
     */
    abstract function deleteID($table, $id);
    
    /**
     * @param string $table
     * @param string $attr
     * @param string $val
     * @return int 
     */
    abstract function deleteVal($table, $attr, $val);
    
    /**
     * @param string $table
     * @param string $id
     * @param string $object
     * @return null|array|Eruda_Model 
     */
    abstract function selectID($table, $id, $object=null);
    
    /**
     * @param string $table
     * @param array $values
     * @param int $start
     * @param string $object
     * @return null|array|Eruda_Model 
     */
    abstract function selectOne($table, $values, $start=0, $object=null);
    
    /**
     * @param string $table
     * @param array $order
     * @param int $start
     * @param int $total
     * @param string $object
     * @return array
     */
    abstract function selectAll($table, $order=null, $start=0, $total = 999999, $object=null);
    
    /**
     * @param string $table
     * @param string $object
     * @return array
     */
    abstract function selectType($table, $object=null, $random = false);
            
    /**
     * @param string $table
     * @param array $values
     * @param int $start
     * @param string $object
     * @return array
     */
    abstract function selectMulti($table, $values, $order=null, $start=0, $total = 999999, $object=null);
    
    
    /**
     * @param string $table
     * @param array $group
     * @param array $order
     * @return array 
     */
    abstract function selectCount($table, $group=null, $order=null);
    
    
    /**
     * @param string $table
     * @param array $values
     * @return int 
     */
    abstract function selectCountValues($table, $values = array());
}


?>
