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
    public static $_protectedValues = array('NOW()', 'RAND()');
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
        $query .= ' WHERE '.$where.';';
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    /**
     * @param string $table
     * @param array $values
     * @param string $id
     * @return int
     */
    function updateID($table, $values, $id) {
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
        
        $query .= ' WHERE id = "'.$id.'";';
        
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    /**
     * @param string $table
     * @param array $values
     * @param string $attr
     * @param string $val
     * @return int
     */
    function updateVal($table, $values, $where){
        $query = 'UPDATE '.$table.' SET ';
        $qvals = array();
        foreach($values as $attr => $val){
            if(in_array($val, Eruda_DBConnector_MYSQLi::$_protectedValues))
                $qvals[] = $attr.' = '.$val;
            else if(is_array($val) && $val[1] = true)
                $qvals[] = $attr.' = '.$val;
            else
                $qvals[] = $attr.' = '.'"'.$this->_mysqli->real_escape_string($id).'"';
        }
        $query .= implode(',', $qvals);
        
        if($where!=null)
            $query .= ' WHERE '.$attr.'="'.$this->_mysqli->real_escape_string($val).'";';
        
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
    
    function deleteVals($table, $values){
        $query = 'DELETE FROM '.$table.' ';
        
        if(count($values)>0){
            $query .= ' WHERE ';
            $qvals = array();
            foreach($values as $attr => $val){
                if(in_array($val, Eruda_DBConnector_MYSQLi::$_protectedValues))
                    $qvals[] = $attr.' = '.$val;
                else if(is_array($val) && $val[1] = true)
                    $qvals[] = $attr.' = '.$val;
                else
                    $qvals[] = $attr.' = '.'"'.$this->_mysqli->real_escape_string($val).'"';
            }

            $query .= implode(' AND ', $qvals).' ';
        }
        
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    /**
     * @param string $table
     * @param string $id
     * @param string $object
     * @return null|array|Eruda_Model 
     */
    function selectID($table, $id, $object=null){
        if($object!=null) $object = 'Eruda_Model_'.$object;
        $query = 'SELECT * FROM '.$table.' WHERE id ="'.$this->_mysqli->real_escape_string($id).'";';
        
        $ret = null;
        if($res = $this->_mysqli->query($query))
            if($object!=null && is_string($object)){
                if($row = $res->fetch_array()){
                    $ret = new $object($row);
                }
            } else {
                $ret = $res->fetch_array();
            }
        $res->close();
        return $ret;
    }
    
    /**
     * @param string $table
     * @param array $values
     * @param int $start
     * @param string $object
     * @return null|array|Eruda_Model 
     */
    function selectOne($table, $values, $start=0, $object=null){
        if($object!=null) $object = 'Eruda_Model_'.$object;
        $query = 'SELECT * FROM '.$table.' WHERE ';
        
        $qvals = array();
        foreach($values as $attr => $val){
            if(in_array($val, Eruda_DBConnector_MYSQLi::$_protectedValues))
                $qvals[] = $attr.' = '.$val;
            else if(is_array($val) && $val[1] = true)
                $qvals[] = $attr.' = '.$val;
            else
                $qvals[] = $attr.' = '.'"'.$this->_mysqli->real_escape_string($val).'"';
        }
        
        $query .= implode(' AND ', $qvals).' ';
        
        $query .= ' LIMIT '.$start.', 1 ;';
        
        $ret = null;
        
        if($res = $this->_mysqli->query($query))
            if($object!=null && is_string($object)){
                if($row = $res->fetch_array()){
                    $ret = new $object($row);
                }
            } else {
                $ret = $res->fetch_array();
            }
        return $ret;
    }
    
    /**
     * @param string $table
     * @param array $values
     * @param int $start
     * @param string $object
     * @return array
     */
    function selectMulti($table, $values, $order=null, $start=0, $total = 999999, $object=null){
        if($object!=null) $object = 'Eruda_Model_'.$object;
        $query = 'SELECT * FROM '.$table.' ';
        
        if(count($values)>0){
            $query .= ' WHERE ';
            $qvals = array();
            foreach($values as $attr => $val){
                if(in_array($val, Eruda_DBConnector_MYSQLi::$_protectedValues))
                    $qvals[] = $attr.' = '.$val;
                else if(is_array($val) && $val[1] = true)
                    $qvals[] = $attr.' = '.$val;
                else
                    $qvals[] = $attr.' = '.'"'.$this->_mysqli->real_escape_string($val).'"';
            }

            $query .= implode(' AND ', $qvals).' ';
        }
        if($order!=null && is_array($order) && count($order)>0){
            $ovals = array();
            foreach($order as $val){
                $ovals[] = $val[0].' '.$val[1];
            }
            $query .= ' ORDER BY '.implode(' , ', $ovals).' ';
        }
        
        $query .= ' LIMIT '.$start.', '.$total.' ;';
        
        $ret = array();
        if($res = $this->_mysqli->query($query))
            if($object!=null && is_string($object)){
                while($row = $res->fetch_array()){
                    $ret[] = new $object($row);
                }
            } else {
                while($row = $res->fetch_array()){
                    $ret[] = $row;
                }
            }
        
        return $ret;
    }
    
    /**
     * @param string $table
     * @param int $start
     * @param string $object
     * @return array
     */
    function selectAll($table, $order=null, $start=0, $total = 999999, $object=null){
        if($object!=null) $object = 'Eruda_Model_'.$object;
        $query = 'SELECT * FROM '.$table.' ';
        
        if($order==null && is_array($order) && count($order)>0){
            $ovals = array();
            foreach($order as $val){
                $ovals[] = $val[0].','.$val[1];
            }
            $query .= ' ORDER BY '.implode(' AND ', $qvals).' ';
        }
        
        $query .= ' LIMIT '.$start.', '.$total.' ;';
        
        $ret = array();
        
        if($res = $this->_mysqli->query($query))
            if($object!=null && is_string($object)){
                while($row = $res->fetch_array()){
                    $ret[] = new $object($row);
                }
            } else {
                while($row = $res->fetch_array()){
                    $ret[] = $row;
                }
            }
        
        return $ret;
    }
    
    
    /**
     * @param string $table
     * @param array $group
     * @param array $order
     * @return array 
     */
    function selectCount($table, $group=null, $order=null){
        $query = null;
        
        if($group==null && is_array($group) && count($group)>0){
            $query = 'SELECT '.implode(',',$group).', count(*) AS count FROM '.$table.' ';
            $query .= ' GROUP BY '.implode(',', $group).' ';
        } else {
            $query = 'SELECT count(*) AS count FROM '.$table.' ';
        }
        
        if($order==null && is_array($order) && count($order)>0){
            $ovals = array();
            foreach($order as $val){
                $ovals[] = $val[0].','.$val[1];
            }
            $query .= ' ORDER BY '.implode(' AND ', $qvals).' ';
        }
        
        $ret = null;
        
        if($group==null && is_array($group) && count($group)>0){
            $ret = array();
            if($res = $this->_mysqli->query($query))
            while($row = $res->fetch_array()){
                $ret[] = $row;
            }
        } else {
            $ret = 0;
            if($res = $this->_mysqli->query($query))
            while($row = $res->fetch_array()){
                $ret = $row['count'];
            }
        }
        
        
        return $ret;
    }
    
    /**
     *
     * @param string $query
     * @return mysqli_result 
     */
    function query($query){
        return $this->_mysqli->query($query);
    }
}
?>