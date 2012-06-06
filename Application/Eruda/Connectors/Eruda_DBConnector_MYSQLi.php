<?php
/**
 * Description of Eruda_DBConnector_MYSQLi
 *
 * @author gaixas1
 */

/**
 * @property string $_host
 * @property string $_dbase
 * @property string $_user
 * @property string $_pass
 * @property int $_port
 * @property mysqli $_mysqli 
 */

class Eruda_DBConnector_MYSQLi extends Eruda_DBConnector {
    public static $_protectedValues = array('NOW');
    protected $_host;
    protected $_dbase;
    protected $_port;
    protected $_user;
    protected $_pass;
    protected $_mysqli;
    
    /**
     * @param string $host
     * @param string $dbase
     * @param string $user
     * @param string $pass
     * @param int $port 
     */
    function __construct($host, $dbase, $user, $pass='', $port=3306){
        $this->setHost($host)->setDBase($dbase)->setUser($user)->setPass($pass)->setPort($port);
        $this->_mysqli = null;
    }
    
    /**
     * @return \Eruda_DBConnector_MYSQLi
     * @throws Exception 
     */
    function connect(){
        $this->_mysqli = @new mysqli($this->_host, $this->_user, $this->_pass, $this->_dbase, $this->_port);   
        if (mysqli_connect_error())
            throw new Exception('Eruda_DBConnector_MYSQLi::connect - CANNOT CONNECT TO DATABASE');
            
        return $this;
    }
    
    /**
     * @return \Eruda_DBConnector_MYSQLi 
     */
    function disconnect(){
        if($this->_mysqli instanceof mysqli)
            $this->_mysqli->close();
        return $this;
    }
    
    /**
     * @param string $host
     * @return \Eruda_DBConnector_MYSQLi
     * @throws Exception 
     */
    function setHost($host){
        if($host!=null && is_string($host))
            $this->_host = $host;
        else
            throw new Exception('Eruda_DBConnector_MYSQLi::setHost - BAD HOST : '.$host);
        return $this;
    }
    
    /**
     * @param string $user
     * @return \Eruda_DBConnector_MYSQLi
     * @throws Exception 
     */
    function setUser($user){
        if($user!=null && is_string($user))
            $this->_user = $user;
        else
            throw new Exception('Eruda_DBConnector_MYSQLi::setUser - BAD USER : '.$user);
        return $this;
    }
    
    /**
     * @param string $user
     * @return \Eruda_DBConnector_MYSQLi
     * @throws Exception 
     */
    function setPass($pass){
        if(($pass!=null && is_string($pass)) || $pass=='')
            $this->_pass = $pass;
        else
            throw new Exception('Eruda_DBConnector_MYSQLi::setPass - BAD PASSWORD : '.$pass);
        return $this;
    }
    
    /**
     * @param string $user
     * @return \Eruda_DBConnector_MYSQLi
     * @throws Exception 
     */
    function setDBase($dbase){
        if($dbase!=null && is_string($dbase))
            $this->_dbase = $dbase;
        else
            throw new Exception('Eruda_DBConnector_MYSQLi::setDBase - BAD DATABASE : '.$dbase);
        return $this;
    }
    
    /**
     * @param int $port
     * @return \Eruda_DBConnector_MYSQLi
     * @throws Exception 
     */
    function setPort($port){
        if($port!=null && is_int($port))
            $this->_port = $port;
        else
            throw new Exception('Eruda_DBConnector_MYSQLi::setPort - BAD HOST : '.$port);
        return $this;
    }
    
    /**
     * @return mysqli 
     */
    function getMYSQLi(){
        return $this->_mysqli;
    }
    
    /**
     * @param string $table
     * @param array $attr
     * @param array $values
     * @return int 
     */
    function insertOne($table, $attr, $values){
        $query = 'INSERT INTO '.$table.' ';
        if(count($attr)>0)
            $query .='('.implode (',', $attr).') ';
        $qvals = array();
        foreach($values as $val){
            if(in_array($val, Eruda_DBConnector_MYSQLi::$_protectedValues))
                $qvals[] = $val;
            else if(is_array($val) && $val[1] = true)
                $qvals[] = $val;
            else
                $qvals[] = '"'.$this->_mysqli->real_escape_string($val).'"';
        }
        $query .= 'VALUES ('.implode(',',$qvals).');';
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    /**
     * @param string $table
     * @param array $attr
     * @param array $values
     * @return int 
     */
    function insertMulti($table, $attr, $values){
        $query = 'INSERT INTO '.$table.' ';
        if(count($attr)>0)
            $query .='('.implode (',', $attr).') ';
        $qins = array();
        foreach($values as $ins){
            $qvals = array();
            foreach($ins as $val){
                if(in_array($val, Eruda_DBConnector_MYSQLi::$_protectedValues))
                    $qvals[] = $val;
                else if(is_array($val) && $val[1] = true)
                    $qvals[] = $val;
                else
                    $qvals[] = '"'.$this->_mysqli->real_escape_string($val).'"';
            }
            $qins[] = '('.implode(',', $qvals).')';
        }
        $query .= 'VALUES '.implode(',',$qins).';';
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    /**
     * @return int 
     */
    function lastID(){
        return $this->_mysqli->insert_id;
    }
    
    /**
     * @param string $table
     * @param array $values
     * @param string $where
     * @return int
     */
    function update($table, $values, $where) {
        $query = 'UPDATE '.$table.' SET ';
        $qvals = array();
        foreach($values as $attr => $val){
            if(in_array($val, Eruda_DBConnector_MYSQLi::$_protectedValues))
                $qvals[] = $attr.' = '.$val;
            else if(is_array($val) && $val[1] = true)
                $qvals[] = $attr.' = '.$val;
            else
                $qvals[] = $attr.' = '.'"'.$this->_mysqli->real_escape_string($val).'"';
        }
        $query .= implode(',', $qvals);
        if($where!=null)
        $query .= ' WHERE '.$where;
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    /**
     * @param string $table
     * @param string $where
     * @return int 
     */
    function delete($table, $where) {
        $query = 'DELETE FROM '.$table.' WHERE '.$where.';';
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    
    /**
     * @param string $table
     * @param int|string $id
     * @return int 
     */
    function deleteID($table, $id){
        $query = 'DELETE FROM '.$table.' WHERE id="'.$this->_mysqli->real_escape_string($id).'";';
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    /**
     * @param string $table
     * @param string $attr
     * @param string $val
     * @return int 
     */
    function deleteVal($table, $attr, $val){
        $query = 'DELETE FROM '.$table.' WHERE '.$attr.'="'.$this->_mysqli->real_escape_string($val).'";';
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    
}
?>