<?php

namespace Zwaldeck\Db\Adapter;

use Zwaldeck\Db\Helpers\Select;
use Zwaldeck\Util\Constants;

/**
 *
 * @author Wout Schoovaerts
 */
class MysqliAdapter extends AbstractAdapter {
	
	/**
	 *
	 * @param string $host        	
	 * @param string $user        	
	 * @param string $pass        	
	 * @param string $dbName        	
	 * @param number $port        	
	 * @param string $charset        	
	 * @throws \mysqli_sql_exception
	 */
	public function __construct($host, $user, $pass, $dbName, $port = Constants::DEFAULT_DATABASE_PORT, $charset = Constants::DEFAULT_DATABASE_CHARSET) {
		parent::__construct ( $host, $user, $pass, $dbName, $port, $charset );
		
		$this->_connection = new \mysqli ( $this->_host, $this->_user, $this->_pass, $this->_dbName, $this->_port );
		
		if (mysqli_connect_error ()) {
			throw new \mysqli_sql_exception ( mysqli_connect_error () );
		}
		
		$this->_connection->set_charset ( $this->_charset );
	}
	
	/**
	 * returns one row in an array(map)
	 *
	 * @param Select $select        	
	 * @return array
	 */
	public function fetchRow(Select $select) {
		$select->limit ( 0, 1 );
		return $this->fetchAssoc ( $select );
	}
	public function fetchAssoc(Select $select) {
		$array = $select->buildQuery ();
		$types = "";
		for($i = 0; $i < count ( $array ["exec"] ); $i ++) {
			$types .= "s";
		}
		$stmt = $this->_connection->prepare ( $array ['query'] );
		if (! empty ( $array ['exec'] ))
			call_user_func_array ( array (
					$stmt,
					'bind_param' 
			), array_merge ( array (
					$types 
			), $array ['exec'] ) );
		
		if ($stmt->errno)
			throw new \Exception ( "SQL error: {$stmt->error}" );
		
		if ($stmt->execute ()) {
			$a = array ();
			$res = $stmt->get_result ();
			while ( $row = $res->fetch_array ( MYSQLI_ASSOC ) ) {
				$a [] = $row;
			}
			
			return $a;
		}
		
		return null;
	}
	
	/**
	 * returns all the rows in an array(map)
	 *
	 * @param string $table        	
	 * @throws \InvalidArgumentException
	 * @return array
	 */
	public function fetchAll($table) {
		if (! is_string ( $table ) || trim ( $table ) == '') {
			throw new \InvalidArgumentException ( 'Table must be a string and can not be empty' );
		}
		$select = new Select ( $this );
		$select->from ( array (
				$table 
		) );
		
		return $this->fetchAssoc ( $select );
	}
	
	/**
	 *
	 * @param string $table        	
	 * @param array $data        	
	 * @param mixed $where
	 *        	--> automaticly AND if array
	 * @throws \InvalidArgumentException
	 * @return integer the affected rows
	 */
	public function update($table, array $data, $where) {
		if (! is_string ( $table ) || trim ( $table ) == '') {
			throw new \InvalidArgumentException ( 'Table must be a string and can not be empty' );
		}
		
		if (! is_array ( $data )) {
			throw new \InvalidArgumentException ( 'Data must be an array' );
		}
		
		if (! is_array ( $where ) && (! is_string ( $where ))) {
			throw new \InvalidArgumentException ( 'Where must be an array or a string' );
		}
		
		$execArray = array ();
		$set = '';
		$whereCluase = '';
		
		foreach ( $data as $key => $value ) {
			$set .= ', ' . $key . ' = ?';
			$execArray [] = $value;
		}
		
		$set = ltrim ( $set, ', ' );
		
		if (is_array ( $where )) {
			foreach ( $where as $key => $value ) {
				$whereCluase = 'AND ' . $key . ' ?';
				$execArray [] = $value;
			}
			$whereCluase = ltrim ( $whereCluase, 'AND ' );
		} elseif (is_string ( $where ) && trim ( $where ) != '') {
			$whereCluase = $where;
		}
		
		$query = "UPDATE {$table} SET {$set} WHERE {$whereCluase}";
		$stmt = $this->_connection->prepare ( $query );
		
		$types = "";
		for($i = 0; $i < count ( $execArray ); $i ++) {
			$types .= "s";
		}
		
		if (! empty ( $execArray )) {
			$tmp = array ();
			$tmp [] = &$types;
			foreach ( $execArray as $key => $value ) {
				$tmp [] = &$execArray [$key];
			}
			call_user_func_array ( array (
					$stmt,
					'bind_param' 
			), $tmp );
		}
		
		if ($stmt->errno) {
			throw new \Exception ( $stmt->error );
		}
		
		if ($stmt->execute ()) {
			return $stmt->affected_rows;
		} else {
			throw new \Exception ( "There went something wrong while updating" );
		}
	}
	
	/**
	 *
	 * @param string $table        	
	 * @param array|string $where        	
	 * @throws \InvalidArgumentException
	 * @throws \Exception
	 * @return boolean
	 */
	public function delete($table, $where) {
		if (! is_string ( $table ) || trim ( $table ) == '') {
			throw new \InvalidArgumentException ( 'Table must be a string and can not be empty' );
		}
		
		if (! is_array ( $where ) && (! is_string ( $where ))) {
			throw new \InvalidArgumentException ( 'Where must be an array or a string' );
		}
		
		$execArray = array ();
		$whereCluase = '';
		
		if (is_array ( $where )) {
			foreach ( $where as $key => $value ) {
				$whereCluase = 'AND ' . $key . ' ?';
				$execArray [] = $value;
			}
			$whereCluase = ltrim ( $whereCluase, 'AND ' );
		} elseif (is_string ( $where ) && trim ( $where ) != '') {
			$whereCluase = $where;
		}
		
		try {
			$query = "DELETE FROM {$table} WHERE {$whereCluase}";
			$stmt = $this->_connection->prepare ( $query );
			
			$types = "";
			for($i = 0; $i < count ( $execArray ); $i ++) {
				$types .= "s";
			}
			
			if (! empty ( $execArray )) {
				$tmp = array ();
				$tmp [] = &$types;
				foreach ( $execArray as $key => $value ) {
					$tmp [] = &$execArray [$key];
				}
				call_user_func_array ( array (
						$stmt,
						'bind_param' 
				), $tmp );
			}
			
			if ($stmt->errno) {
				throw new \Exception ( $stmt->error );
			}
			
			return $stmt->execute ();
		} catch ( \Exception $e ) {
			throw new \Exception ( $e->getMessage () );
		}
		
		return false;
	}
	
	/**
	 * Insert field to database
	 *
	 * @param string $table        	
	 * @param array $data        	
	 * @throws \InvalidArgumentException
	 * @return boolean
	 */
	public function insert($table, array $data) {
		if (! is_string ( $table ) || trim ( $table ) == '') {
			throw new \InvalidArgumentException ( 'Table must be a string and can not be empty' );
		}
		
		if (! is_array ( $data )) {
			throw new \InvalidArgumentException ( 'Data must be an array' );
		}
		
		$execArray = array ();
		$columns = '';
		$values = '';
		foreach ( $data as $key => $value ) {
			$columns .= ', ' . $key;
			
			$values .= ', ?';
			$execArray [] = $value;
		}
		$columns = ltrim ( $columns, ', ' );
		$values = ltrim ( $values, ', ' );
		
		$stmt = $this->_connection->prepare ( "INSERT INTO {$table} ({$columns}) VALUES ({$values})" );
		
		$types = "";
		for($i = 0; $i < count ( $execArray ); $i ++) {
			$types .= "s";
		}
		
		if (! empty ( $execArray )) {
			$tmp = array ();
			$tmp [] = &$types;
			foreach ( $execArray as $key => $value ) {
				$tmp [] = &$execArray [$key];
			}
			call_user_func_array ( array (
					$stmt,
					'bind_param' 
			), $tmp );
		}
		return $stmt->execute ();
	}
	
	/**
	 * Returns the last inserted id
	 *
	 * @return mixed
	 */
	public function getLastInsertId() {
		return $this->_connection->insert_id;
	}
	/**
	 * executes a raw query
	 *
	 * @throws \InvalidArgumentException
	 * @return mixed
	 */
	public function rawQuery($query) {
		$stmt = $this->_connection->query ( $query );
		
		return $stmt;
	}
	
	/**
	 * returns the mysqli object
	 *
	 * @return \mysqli
	 */
	public function getConnection() {
		return $this->_connection;
	}
	
	/**
	 * returns an array of all the fields in the table
	 *
	 * @throws \InvalidArgumentException
	 * @return array
	 */
	public function getTableFields($table) {
		if (! is_string ( $table ) || trim ( $table ) == '') {
			throw new \InvalidArgumentException ( 'Table must be a string and can not be empty' );
		}
		
		$stmt = $this->_connection->prepare ( "DESCRIBE {$table}" );
		
		if ($stmt->execute ()) {
			$a = array ();
			$res = $stmt->get_result ();
			while ( $row = $res->fetch_array ( MYSQLI_ASSOC ) ) {
				$a [] = $row ['Field'];
			}
			
			return $a;
		} else {
			throw new \Exception ( 'There went somthing wrong while fetching the tables fields' );
		}
	}
}

?>