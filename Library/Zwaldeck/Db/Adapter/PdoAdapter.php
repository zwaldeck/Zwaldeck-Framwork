<?php

namespace Zwaldeck\Db\Adapter;

use Zwaldeck\Db\Helpers\Select;
use Zwaldeck\Util\Constants;

/**
 * 
 * @author Wout Schoovaerts
 */
class PdoAdapter extends AbstractAdapter {
	/**
	 * 
	 * @param string $host
	 * @param string $user
	 * @param string $pass
	 * @param string $dbName
	 * @param number $port
	 * @param string $charset
	 */
	public function __construct($host, $user, $pass, $dbName, $port = Constants::DEFAULT_DATABASE_PORT, $charset = Constants::DEFAULT_DATABASE_CHARSET) {
		parent::__construct ( $host, $user, $pass, $dbName, $port, $charset );
		
		$connectionString = "mysql:host={$this->_host};port={$this->_port};dbname={$this->_dbName};charset={$this->_charset}";
		$this->_connection = new \PDO ( $connectionString, $this->_user, $this->_pass, array (
				\PDO::ATTR_EMULATE_PREPARES => false,
				\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION 
		) );
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
	
	/**
	 * returns the rows of the query in an array(map)
	 *
	 * @param Select $select        	
	 * @return array
	 */
	public function fetchAssoc(Select $select) {
		$array = $select->buildQuery ();
		$stmt = $this->_connection->prepare ( $array ['query'] );
		try {
			$stmt->execute ( $array ['exec'] );
			$res = $stmt->fetchAll ( \PDO::FETCH_ASSOC );
		} catch ( \PDOException $e ) {
			throw new \Exception($e->getMessage());
		}
		return $res;
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
	 * @param array|string $where   
	 * 					--> automaticly And if array
	 * @throws \InvalidArgumentException
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
			$i = 1;
			foreach($execArray as $value) {
				$stmt->bindParam($i, $value);
				$i++;
			}
			return $stmt->execute ();
		} catch ( \PDOException $e ) {
			throw new \Exception ( $e->getMessage () );
		}
		
		return false;
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
		try {
			$query = "UPDATE {$table} SET {$set} WHERE {$whereCluase}";
			$stmt = $this->_connection->prepare ( $query );
			$stmt->execute ( $execArray );
		} catch ( \PDOException $e ) {
			throw new \Exception ( $e->getMessage () );
		}
		
		return $stmt->rowCount ();
	}
	
	/**
	 * Insert field to database
	 *
	 * @param string $table        	
	 * @param array $data  
	 * @throws \InvalidArgumentException      
	 * @throws \Exception  	
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
		
		try {
			$stmt = $this->_connection->prepare ( "INSERT INTO {$table} ({$columns}) VALUES ({$values})" );
			return $stmt->execute ( $execArray );
		} catch ( \PDOException $e ) {
			throw new \Exception ( $e->getMessage () );
		}
		
		return false;
	}
	
	/**
	 * returns the last inserted id
	 *
	 * @return string
	 */
	public function getLastInsertId() {
		return $this->_connection->lastInsertId ();
	}
	
	/**
	 *
	 * @param string $query        	
	 * @return \PDOStatement
	 */
	public function rawQuery($query) {
		$stmt = $this->_connection->query ( $query );
		
		return $stmt;
	}
	
	/**
	 * Returns the connection object
	 *
	 * @return \PDO
	 */
	public function getConnection() {
		return $this->_connection;
	}
	
	/**
	 *
	 * @see \Zwaldeck\Db\Adapter\AbstractAdapter::getTableFields()
	 */
	public function getTableFields($table) {
		if (! is_string ( $table ) || trim ( $table ) == '') {
			throw new \InvalidArgumentException ( 'Table must be a string and can not be empty' );
		}
		
		$stmt = $this->_connection->prepare ( "DESCRIBE {$table}" );
		$stmt->execute ();
		
		return $stmt->fetchAll ( \PDO::FETCH_COLUMN );
	}
}

?>