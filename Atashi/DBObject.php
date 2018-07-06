<?php

namespace Atashi;

class DBObject {
	public $config;
	/**
	 *
	 * @var \Mysqli $rep
	 */
	public $rep;
	function __construct(Array $config) {
		$this->config = $config;
		$this->rep = new \Mysqli ( $this->config ['host'], $this->config ['user'], $this->config ['password'], $this->config ['dbname'] );
		
		$this->rep->set_charset ( $this->config ['charset'] );
		foreach ( $this->config ['driverOptions'] as $option => $value ) {
			$this->rep->set_opt ( $option, $value );
		}
		
		$this->rep->autocommit ( true );
	}
	function getAll($from, $pars = '*', $where = null, $order = null, $offset = null, $limit = null) {
		$query = 'SELECT ' . $pars . ' FROM ' . $from;
		if ($where !== null)
			$query .= ' WHERE ' . $where;
		if ($order !== null)
			$query .= ' ORDER BY ' . $order;
		if ($limit !== null)
			$query .= ' LIMIT ' . $limit;
		if ($offset !== null)
			$query .= ' OFFSET ' . $offset;
		$query .= ';';
		$result = $this->rep->query ( $query );
		$vals = array ();
		// echo $query.PHP_EOL;
		if ($result)
			while ( $row = $result->fetch_assoc () )
				$vals [] = $row;
		
		return $vals;
	}
	function getOne($from, $pars = '*', $where = null, $order = null, $offset = null) {
		$query = 'SELECT ' . $pars . ' FROM ' . $from;
		if ($where !== null)
			$query .= ' WHERE ' . $where;
		if ($order !== null)
			$query .= ' ORDER BY ' . $order;
		$query .= ' LIMIT 1';
		if ($offset !== null)
			$query .= ' OFFSET ' . $offset;
		$query .= ';';
		
		// Log::add($query);
		$result = $this->rep->query ( $query );
		
		$val = null;
		if ($result)
			while ( $row = $result->fetch_assoc () )
				$val = $row;
		
		return $val;
	}
	function getAllJoin($from, $join, $joinAttr, $where = null, $order = null, $offset = null, $limit = null) {
		$query = 'SELECT a.* FROM ' . $from . ' AS a, ' . $join . ' as b';
		$query .= ' WHERE a.id = b.' . $joinAttr;
		if ($where !== null)
			$query .= ' AND ( ' . $where . ' )';
		if ($order !== null)
			$query .= ' ORDER BY ' . $order;
		if ($limit !== null)
			$query .= ' LIMIT ' . $limit;
		if ($offset !== null)
			$query .= ' OFFSET ' . $offset;
		$query .= ';';
		
		// Log::add($query);
		$result = $this->rep->query ( $query );
		
		$vals = array ();
		
		if ($result)
			while ( $row = $result->fetch_assoc () )
				$vals [] = $row;
		
		return $vals;
	}
	function getOneJoin($from, $join, $joinAttr, $where = null, $order = null, $offset = null) {
		$query = 'SELECT a.* FROM ' . $from . ' AS a, ' . $join . ' as b';
		$query .= ' WHERE a.id = b.' . $joinAttr;
		if ($where !== null)
			$query .= ' AND ( ' . $where . ' )';
		if ($order !== null)
			$query .= ' ORDER BY ' . $order;
		$query .= ' LIMIT 1';
		if ($offset !== null)
			$query .= ' OFFSET ' . $offset;
		$query .= ';';
		
		// Log::add($query);
		$result = $this->rep->query ( $query );
		
		$val = null;
		if ($result)
			while ( $row = $result->fetch_assoc () )
				$val = $row;
		
		return $val;
	}
	function escape($v) {
		if ($v === true) {
			return "true";
		}
		if ($v === false) {
			return "false";
		}
		if (is_int ( $v )) {
			return $v;
		}
		return '"' . $this->rep->escape_string ( $v ) . '"';
	}
	function save($table, $values) {
		$pars = array ();
		$vals = array ();
		foreach ( $values as $k => $v ) {
			$pars [] = $k;
			$vals [] = $this->escape ( $v );
		}
		$query = 'INSERT INTO ' . $table . ' (' . implode ( ',', $pars ) . ') VALUES (' . implode ( ',', $vals ) . ');';
		// Log::add($query);
		$this->rep->query ( $query );
		return $this->rep->insert_id;
	}
	function update($table, $id, $values = array(), $idattr = 'id') {
		$query = 'UPDATE ' . $table . ' SET ';
		$first = true;
		foreach ( $values as $k => $v ) {
			if (! $first) {
				$query .= ', ' . $k . ' = ' . $this->escape ( $v );
			} else {
				$query .= ' ' . $k . ' = ' . $this->escape ( $v );
				$first = false;
			}
		}
		$query .= ' WHERE ' . $idattr . ' = ' . $id;
		$query .= ';';
		$this->rep->query ( $query );
	}
	function saveOrUpdate($table, $values = array()) {
		$pars = array ();
		$vals = array ();
		$upVals = array ();
		foreach ( $values as $k => $v ) {
			$pars [] = $k;
			$vals [] = $this->escape ( $v );
			$upVals [] = $k . ' = ' . $this->escape ( $v );
		}
		$query = 'INSERT INTO ' . $table . ' (' . implode ( ',', $pars ) . ') VALUES (' . implode ( ',', $vals ) . ') ON DUPLICATE KEY UPDATE ' . implode ( ',', $upVals ) . ';';
		$this->rep->query ( $query );
		return $this->rep->insert_id;
	}
	function delete($from, $where) {
		$query = 'DELETE FROM ' . $from . ' WHERE ' . $where . ';';
		$this->rep->query ( $query );
		echo $query . PHP_EOL;
	}
	function getCount($table, $where = null) {
		$query = 'SELECT count(*) as c FROM ' . $table;
		if ($where !== null)
			$query .= ' WHERE ' . $where;
		$query .= ';';
		$result = $this->rep->query ( $query );
		
		$val = 0;
		if ($result)
			while ( $row = $result->fetch_assoc () )
				$val = $row ['c'];
		
		return $val;
	}
	function getJointCount($table, $join, $joinAttr, $where) {
		$query = 'SELECT a.* FROM ' . $from . ' AS a, ' . $join . ' as b';
		$query .= ' WHERE a.id = b.' . $joinAttr;
		if ($where !== null)
			$query .= ' AND ( ' . $where . ' )';
		$query .= ';';
		$result = $result = $this->rep->query ( $query );
		
		$val = 0;
		if ($result)
			while ( $row = $result->fetch_assoc () )
				$val = $row ['c'];
		
		return $val;
	}
	function execute($query, $retType = null) {
		$result = $this->rep->query ( $query );
		switch ($retType) {
			case 'single' :
				if ($result) {
					while ( $row = $result->fetch_assoc () ) {
						return $row;
					}
				}
				return null;
			case 'multiple' :
				$vals = array ();
				if ($result) {
					while ( $row = $result->fetch_assoc () ) {
						$vals [] = $row;
					}
				}
				return $vals;
		}
	}
}