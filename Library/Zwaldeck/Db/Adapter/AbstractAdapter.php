<?php

namespace Zwaldeck\Db\Adapter;

use Zwaldeck\Db\Helpers\Select;
use Zwaldeck\Util\Constants;

/**
 * 
 * @author Wout Schoovaerts
 */
abstract class AbstractAdapter {
	
	/**
	 * Host of the database
	 * @var string
	 */
	protected $_host;
	
	/**
	 * the user of the database
	 * @var string
	 */
	protected $_user;
	
	/**
	 * the pass of the user
	 * @var string
	 */
	protected $_pass;
	
	/**
	 * the database name
	 * @var string
	 */
	protected $_dbName;
	
	/**
	 * the port number
	 * Default: Constants::DEFAULT_DATABASE_PORT
	 * @var integer
	 */
	protected $_port;
	
	/**
	 * the charset string
	 * Default: Constants::DEFAULT_DATABASE_CHARSET
	 * @var string
	 */
	protected $_charset;
	
	/**
	 * 
	 * @var \mysqli|PDO
	 */
	protected $_connection;
	
	/**
	 * @var Select
	 */
	protected $_select = null;
	
	/**
	 * 
	 * @param string $host
	 * @param string $user
	 * @param string $pass
	 * @param string $dbName
	 * @param integer $port
	 * @param string $charSet
	 */
	public function __construct($host, $user, $pass, $dbName, $port = Constants::DEFAULT_DATABASE_PORT, $charSet = Constants::DEFAULT_DATABASE_CHARSET) {
		
		$this->checkParam($host, 'string', 'host');
		$this->checkParam($user, 'string', 'user');
		$this->checkParam($pass, 'string', 'pass');
		$this->checkParam($dbName, 'string', 'dbName');
		$this->checkParam($port, 'int', 'port');
		$this->checkParam($charSet, 'string', 'charSet');
		
		$this->_host = $host;
		$this->_user = $user;
		$this->_pass = $pass;
		$this->_dbName = $dbName;
		$this->_port = $port;
		$this->_charset = $charSet;		
	}
	
	public abstract function getConnection();
	
	public abstract function getLastInsertId();
	public abstract function rawQuery($query);
	
	public abstract function fetchAssoc(Select $select);
	public abstract function fetchAll($table);
	public abstract function fetchRow(Select $select);
	public abstract function insert($table, array $data);
	public abstract function update($table, array $data, $where);
	public abstract function delete($table, $where);
	
	/**
	 * 
	 * @param string $table
	 * @return array
	 */
	public abstract function getTableFields($table);
	
	/**
	 * Creates a select if not exist and returns it
	 * @return Select
	 */
	public function select() {
		if($this->_select == null) {
			$this->_select = new Select($this);
		}
		
		return $this->_select;
	}
	
	/**
	 * Checks the parameter with corresponding type
	 * @param mixed $param
	 * @param string $type
	 * @param string $paramName
	 * @throws \InvalidArgumentException
	 */
	private function checkParam($param, $type, $paramName) {
		if(strtolower($type) == 'string') {
			if(trim($param) == '' || !is_string($param)) {
				throw new \InvalidArgumentException("Parameter {$paramName}: needs to be a string and may not be empty");
			}
		}
		else if(strtolower($type) == 'int') {
			if(!is_int($param))
				throw new \InvalidArgumentException("Parameter {$paramName}: needs to be an integer");
		}
	}
	
}

?>