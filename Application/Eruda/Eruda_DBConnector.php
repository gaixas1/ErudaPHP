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
}

?>
