<?php
/**
 * Description of eDBConnector  => MYSQLi
 * Eruda DataBase Connector with MYSQLi object
 *
 * @author gaixas1
 */
class eDBConnector_MYSQLi implements Eruda_DBConnector {
    public static $_protectedValues = array('NOW()', 'RAND()', 'NULL');
    protected $_host;
    protected $_dbase;
    protected $_port;
    protected $_user;
    protected $_pass;
    protected $_mysqli;
    
    function __construct($host, $dbase, $user, $pass='', $port=3306){
        $this->setHost($host)->setDBase($dbase)->setUser($user)->setPass($pass)->setPort($port);
        $this->_mysqli = null;
    }
    function connect(){
        $this->_mysqli = @new mysqli($this->_host, $this->_user, $this->_pass, $this->_dbase, $this->_port);   
        if (mysqli_connect_error())
            throw new Exception('Eruda_DBConnector_MYSQLi::connect - CANNOT CONNECT TO DATABASE');
        if (!$this->_mysqli->set_charset("utf8"))
            throw new Exception('Eruda_DBConnector_MYSQLi::connect - CANNOT CHANGE TO UTF8');
        return $this;
    }
    function disconnect(){
        if($this->_mysqli instanceof mysqli)
            $this->_mysqli->close ();
        return $this;
    }
    function setHost($host){
        $this->_host = $host;
        return $this;
    }
    
    function setUser($user){
        $this->_user = $user;
        return $this;
    }
    
    function setPass($pass){
        $this->_pass = $pass;
        return $this;
    }
    function setDBase($dbase){
        $this->_dbase = $dbase;
        return $this;
    }
    
    function setPort($port){
        $this->_port = $port;
        return $this;
    }
    
    function getMYSQLi(){
        return $this->_mysqli;
    }
    
/* private functions*/
    private function ivals($values){
        $qvals = array();
        foreach($values as $val){
            if(in_array($val, Eruda_DBConnector_MYSQLi::$_protectedValues) || is_array($val) && $val[1] = true)
                $qvals[] = $val;
            else
                $qvals[] = '"'.$this->_mysqli->real_escape_string($val).'"';
        }
        return $qvals;
    }
    
    private function uvals($values){
        $qvals = array();
        foreach($values as $attr => $val){
            if(in_array($val, Eruda_DBConnector_MYSQLi::$_protectedValues))
                $qvals[] = $attr.' = '.$val;
            else if(is_array($val) && $val[1] = true)
                $qvals[] = $attr.' = '.$val;
            else
                $qvals[] = $attr.' = '.'"'.$this->_mysqli->real_escape_string($val).'"';
        }
        return $qvals;
    }
    
    private function oque($values){
        if($values!=null && count($values)>0){
            $ovals = array();
            foreach($values as $val){
                $ovals[] = $val[0].' '.$val[1];
            }
            return ' ORDER BY '.implode(' , ', $ovals).' ';
        }
        return  '';
    }
    
    private function sOne($query){
        $ret = null;
        $res = $this->_mysqli->query($query);
        if($res){
            $ret = $res->fetch_array();
        }
        return $ret;
    }
    
    private function sOneObject($query, $object){
        $ret = null;
        $res = $this->_mysqli->query($query);
        if($res){
            $row = $res->fetch_array();
            if($row){
                $ret = new $object($row);
            }
        }
        return $ret;
    }
    private function sMul($query){
        $ret = array();
        $res = $this->_mysqli->query($query);
        if($res){
            while($row = $res->fetch_array()){
                $ret[] = $row;
            }
        }
        return $ret;
    }
    
    private function sMulObject($query, $object){
        $ret = null;
        $res = $this->_mysqli->query($query);
        if($res){
            while($row = $res->fetch_array()){
                $ret[] = new $object($row);
            }
        }
        return $ret;
    }
    
/* Insert functions*/
    function insertOne($table, $attr, $values){
        $query = 'INSERT INTO '.$table.' ';
        if(count($attr)>0) $query .='('.implode (',', $attr).') ';
        
        $qvals = $this->ivals($values);
        $query .= 'VALUES ('.implode(',',$qvals).');';
        
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    function insertMulti($table, $attr, $values){
        $query = 'INSERT INTO '.$table.' ';
        
        if(count($attr)>0) $query .='('.implode (',', $attr).') ';
        
        $qins = array();
        foreach($values as $ins){
            $qvals = $this->ivals($ins);
            $qins[] = '('.implode(',', $qvals).')';
        }
        $query .= 'VALUES '.implode(',',$qins).';';
        
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    
/* update functions*/
    function update($table, $values, $where = null) {
        $query = 'UPDATE '.$table.' SET ';
        
        $qvals = $this->uvals($values);
        $query .= implode(',', $qvals);
        
        if($where!=null) $query .= ' WHERE '.$where.';';
        
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    function updateID($table, $values, $id) {
        $query = 'UPDATE '.$table.' SET ';
        
        $qvals = $this->uvals($values);
        $query .= implode(',', $qvals);
        
        $query .= ' WHERE id = "'.$this->_mysqli->real_escape_string($id).'";';
        
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    function updateVal($table, $values, $where = null){
        $query = 'UPDATE '.$table.' SET ';
        
        $qvals = $this->uvals($values);
        $query .= implode(',', $qvals);
        
        if($where!=null) $query .= ' WHERE '.$attr.'="'.$this->_mysqli->real_escape_string($val).'";';
        
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
/* delete functions*/
    function delete($table, $where) {
        $query = 'DELETE FROM '.$table.' WHERE '.$where.';';
        
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    function deleteID($table, $id){
        $query = 'DELETE FROM '.$table.' WHERE id = "'.$this->_mysqli->real_escape_string($id).'";';
        
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    function deleteVal($table, $attr, $val){
        $query = 'DELETE FROM '.$table.' WHERE '.$attr.'="'.$this->_mysqli->real_escape_string($val).'";';
        
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    function deleteVals($table, $values = array()){
        $query = 'DELETE FROM '.$table.' ';
        
        if(count($values)>0){
            $query .= ' WHERE ';
            $qvals = $this->uvals($values);
            $query .= implode(' AND ', $qvals).' ';
        }
        
        $this->_mysqli->query($query);
        return $this->_mysqli->affected_rows;
    }
    
    
/* Select functions*/
    function lastID(){
        return $this->_mysqli->insert_id;
    }
    
    function selectID($table, $id, $object=null){
        $query = 'SELECT * FROM '.$table.' WHERE id ="'.$this->_mysqli->real_escape_string($id).'";';
        
        if($object!=null) {
            return $this->sOneObject($query, 'eModel_'.$object);
        } else{
            return $this->sOne($query);
        }
    }
    
    function selectOne($table, $values=array(), $start=0, $object=null){
        $query = 'SELECT * FROM '.$table.' ';
        
        if(count($values)>0){
            $query .= ' WHERE ';
            $qvals = $this->uvals($values);
            $query .= implode(' AND ', $qvals).' ';
        }
        $query .= ' LIMIT '.$start.', 1 ;';
        
        if($object!=null) {
            return $this->sOneObject($query, 'eModel_'.$object);
        } else{
            return $this->sOne($query);
        }
    }
    
    function selectMulti($table, $values=array(), $order=array(), $start=0, $total = 999999, $object=null){
        $query = 'SELECT * FROM '.$table.' ';
        
        if(count($values)>0){
            $query .= ' WHERE ';
            $qvals = $this->uvals($values);
            $query .= implode(' AND ', $qvals).' ';
        }
        
        $query .= $this->oque($order);
        
        $query .= ' LIMIT '.$start.', '.$total.' ;';
        
        if($object!=null) {
            return $this->sMulObject($query, 'eModel_'.$object);
        } else{
            return $this->sMul($query);
        }
    }
    
    function selectAll($table, $order=array(), $start=0, $total = 999999, $object=null){
        $query = 'SELECT * FROM '.$table.' ';
        
        $query .= $this->oque($order);
        
        $query .= ' LIMIT '.$start.', '.$total.' ;';
        
        if($object!=null) {
            return $this->sMulObject($query, 'eModel_'.$object);
        } else{
            return $this->sMul($query);
        }
    }
    
    function selectCount($table, $group=null, $order=array()){
        $query = null;
        
        if($group!=null && count($group)>0){
            $query = 'SELECT '.implode(',',$group).', count(*) AS count FROM '.$table.' GROUP BY '.implode(',', $group).' ';
        } else {
            $query = 'SELECT count(*) AS count FROM '.$table.' ';
        }
        
        $query .= $this->oque($order);
        
        $ret = null;
        $res = $this->_mysqli->query($query);
        if($group!=null && count($group)>0){
            $ret = array();
            if($res)
                while($row = $res->fetch_array()){
                    $ret[] = $row;
                }
        } else {
            $ret = 0;
            if($res)
                while($row = $res->fetch_array()){
                    $ret = $row['count'];
                }
        }
        return $ret;
    }
    
    function selectCountValues($table, $values = array()){
        $query = 'SELECT count(*) AS count FROM '.$table;
        
        if(count($values)>0){
            $query .= ' WHERE ';
            $qvals = $this->uvals($values);
            $query .= implode(' AND ', $qvals).' ';
        }
        
        $query .= ' ;';
        
        $ret = 0;
        $res = $this->_mysqli->query($query);
        if($res) {
            $row = $res->fetch_array();
            if($row){
                $ret = $row['count'];
            }
        }
        
        return $ret;
    }
    

    public function selectType($table, $object = null, $random = false) {
        if($random)
            $query = 'SELECT * FROM '.$table.' ORDER BY RAND();';
        else
            $query = 'SELECT * FROM '.$table.' ;';
        
        if($object!=null) {
            return $this->sMulObject($query, 'eModel_'.$object);
        } else{
            return $this->sMul($query);
        }
        
    }
    
/* Do query*/
    function query($query){
        return $this->_mysqli->query($query);
    }
}
?>