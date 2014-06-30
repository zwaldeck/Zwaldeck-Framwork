<?php

namespace Zwaldeck\Db\Helpers;

use Zwaldeck\Db\Adapter\AbstractAdapter;

class Select {
	const SQL_AND = 'AND';
	const SQL_OR = 'OR';
	const SQL_FIRST = '';
	const SQL_JOIN_TYPE_LEFT = 'LEFT JOIN';
	const SQL_JOIN_TYPE_RIGHT = 'RIGHT JOIN';
	const SQL_JOIN_TYPE_INNER = 'INNER JOIN';
	const SQL_JOIN_TYPE_NONE = 'JOIN';
	const SQL_ORDER_DESC = 'DESC';
	const SQL_ORDER_ASC = 'ASC';
	const SQL_ORDER_DEFAULT = '';
	
	/**
	 *
	 * @var AbstractAdapter
	 */
	private $_adapter;
	
	/**
	 *
	 * @var array
	 */
	private $fields = array ();
	
	/**
	 * first element from, the rest is for join
	 *
	 * @var array
	 */
	private $table = array ();
	
	/**
	 *
	 * @var array
	 */
	private $where = array ();
	
	/**
	 *
	 * @var array
	 */
	private $whereValues = array ();
	
	/**
	 *
	 * @var array
	 */
	private $whereType = array ();
	
	/**
	 *
	 * @var array
	 */
	private $join = array ();
	
	/**
	 *
	 * @var array
	 */
	private $onConditions = array ();
	
	/**
	 *
	 * @var array
	 */
	private $group = array ();
	
	/**
	 *
	 * @var array
	 */
	private $having = array ();
	
	/**
	 * 
	 * @var array
	 */
	private $havingValues = array();
	
	/**
	 *
	 * @var array
	 */
	private $havingType = array ();
	
	/**
	 *
	 * @var array
	 */
	private $order = array ();
	
	/**
	 *
	 * @var array
	 */
	private $limit = array ();
	
	/**
	 *
	 * @var string
	 */
	private $orderType = 'ASC';
	
	/**
	 *
	 * @param AbstractAdapter $adapter        	
	 */
	public function __construct(AbstractAdapter $adapter) {
		$this->_adapter = $adapter;
	}
	
	/**
	 *
	 * @param array $table        	
	 * @param array $fields        	
	 * @return \Zwaldeck\Db\Helpers\Select
	 */
	public function from(array $table, array $fields = array()) {
		if (! is_array ( $table )) {
			throw new \InvalidArgumentException ( 'Table must be an array' );
		}
		if (! is_array ( $fields )) {
			throw new \InvalidArgumentException ( 'Fields must be an array' );
		}
		
		if (empty ( $fields )) {
			$this->fields = $this->_adapter->getTableFields ( current ( $table ) );
		} else {
			$this->fields = $fields;
		}
		
		$key = key ( $table );
		if (! is_numeric ( $key )) {
			$this->table [$key] = current ( $table );
		} else {
			$this->table [] = current ( $table );
		}
		
		return $this;
	}
	
	/**
	 *
	 * @param string $condition        	
	 * @param string $value        	
	 * @param string $type        	
	 * @throws \Exception
	 * @return Select
	 */
	public function where($condition, $value, $type = self:: SQL_AND) {
		if (empty ( $this->where ) && $type != self::SQL_FIRST) {
			throw new \Exception ( 'First where statement must have type = Select::SQL_FIRST' );
		}
		
		$this->where [] = $condition;
		$this->whereValues [] = $value;
		$this->whereType [] = $type;
		
		return $this;
	}
	
	/**
	 *
	 * @param string $field        	
	 * @param array $values        	
	 * @param string $type        	
	 * @throws \Exception
	 * @return \Zwaldeck\Db\Helpers\Select
	 */
	public function inWhere($field, array $values, $type = self::SQL_AND) {
		if (empty ( $this->where ) && $type != self::SQL_FIRST) {
			throw new \Exception ( 'First where statement must have type = Select::SQL_FIRST' );
		}
		$this->where ['in'] = $field;
		$this->whereValues [] = $values;
		$this->whereType [] = $type;
		return $this;
	}
	
	/**
	 *
	 * @param array $table        	
	 * @param string $onCondition        	
	 * @param string $type        	
	 * @return \Zwaldeck\Db\Helpers\Select
	 */
	public function join(array $table, $onCondition, $type = self::SQL_JOIN_TYPE_NONE) {
		$this->table [key ( $table )] = current ( $table );
		$this->join [] = $type;
		$this->onConditions [] = $onCondition;
		
		return $this;
	}
	
	/**
	 *
	 * @param array $groups        	
	 * @return \Zwaldeck\Db\Helpers\Select
	 */
	public function group(array $groups) {
		$this->group = $groups;
		
		return $this;
	}
	
	/**
	 *
	 * @param string $condition        	
	 * @param string $value        	
	 * @param string $type        	
	 * @throws \Exception
	 * @return \Zwaldeck\Db\Helpers\Select
	 */
	public function having($condition, $value, $type = self:: SQL_AND) {
		if (empty ( $this->having ) && $type != self::SQL_FIRST) {
			throw new \Exception ( 'First having statement must have type = Select::SQL_FIRST' );
		}
		
		$this->having [] = $condition;
		$this->havingValues [] = $value;
		$this->havingType [] = $type;
		
		return $this;
	}
	
	/**
	 *
	 * @param string $field        	
	 * @param array $values        	
	 * @param string $type        	
	 * @throws \Exception
	 * @return \Zwaldeck\Db\Helpers\Select
	 */
	public function inHaving($field, array $values, $type = self::SQL_AND) {
		if (empty ( $this->having ) && $type != self::SQL_FIRST) {
			throw new \Exception ( 'First having statement must have type = Select::SQL_FIRST' );
		}
		$this->having ['in'] = $field;
		$this->havingValues [] = $values;
		$this->havingType [] = $type;
		return $this;
	}
	
	/**
	 *
	 * @param array $orderFields        	
	 * @param string $type        	
	 * @return \Zwaldeck\Db\Helpers\Select
	 */
	public function order(array $orderFields, $type = self::SQL_ORDER_DEFAULT) {
		$this->order = $orderFields;
		$this->orderType = $type;
		
		return $this;
	}
	/**
	 *
	 * @param number $min        	
	 * @param number $max        	
	 * @throws \Exception
	 * @return \Zwaldeck\Db\Helpers\Select
	 */
	public function limit($min = 0, $max = 1000) {
		if (is_numeric ( $min ) && is_numeric ( $max )) {
			$this->limit ['min'] = $min;
			$this->limit ['max'] = $max;
		} else {
			throw new \Exception ( 'Parameters must be both numeric' );
		}
		
		return $this;
	}
	public function buildQuery() {
		$execArray = array ();
		// fields
		$fields = '';
		foreach ( $this->fields as $alias => $field ) {
			if (! is_numeric ( $alias )) {
				$fields .= ', ' . $field . ' AS ' . $alias;
			} else {
				$fields .= ', ' . $field;
			}
		}
		$fields = ltrim ( $fields, ', ' );
		// end fields
		
		// from
		$fromAlias = key ( $this->table );
		if(!is_numeric($fromAlias)){
			$from = array_shift ( $this->table ) . ' AS ' . $fromAlias;
		}
		else {
			$from = array_shift ( $this->table );
		}
		
		// end from
		
		// join
		$join = '';
		for($i = 0; $i < count ( $this->join ); $i ++) {
			$join .= ' ' . current ( $this->join ) . ' ';
			
			if (! is_numeric ( key ( $this->table ) )) {
				$join .= current ( $this->table ) . ' AS ' . key ( $this->table );
			} else {
				$join .= current ( $this->table );
			}
			
			$join .= ' ON ' . current ( $this->onConditions );
			next ( $this->join );
			next ( $this->table );
			next ( $this->onConditions );
		}
		// end join
		
		// where
		$where = '';
		for($i = 0; $i < count ( $this->where ); $i ++) {
			$where .= current ( $this->whereType );
			if (key ( $this->where ) === 'in') {
				$where .= ' ' . current ( $this->where ) . ' IN (';
				$subWhere = '';
				foreach ( current ( $this->whereValues ) as $value ) {
					$subWhere .= ', ?';
					$execArray [] = $value;
				}
				$subWhere = ltrim ( $subWhere, ', ' );
				$where .= $subWhere . ') ';
			} else {
				$where .= ' ' . current ( $this->where ) . ' ? ';
				$execArray [] = current ( $this->whereValues );
			}
			
			next ( $this->whereType );
			next ( $this->whereValues );
			next ( $this->where );
		}
		// end where
		
		// group
		$group = '';
		foreach ( $this->group as $groupField ) {
			$group .= ', ' . $groupField;
		}
		$group = ltrim ( $group, ', ' );
		// end group
		
		// having
		$having = '';
		for($i = 0; $i < count ( $this->having ); $i ++) {
			$having .= current ( $this->havingType );
			if (key ( $this->having ) === 'in') {
				$having .= ' ' . current ( $this->having ) . ' IN (';
				$subhaving = '';
				foreach ( current ( $this->havingValues ) as $value ) {
					$subhaving .= ', ?';
					$execArray [] = $value;
				}
				$subhaving = ltrim ( $subhaving, ', ' );
				$having .= $subhaving . ') ';
			} else {
				$having .= ' ' . current ( $this->having ) . ' ? ';
				$execArray [] = current ( $this->havingValues );
			}
			
			next ( $this->havingType );
			next ( $this->having );
			next ($this->havingValues);
		}
		// end having
		
		// order
		$order = '';
		foreach ( $this->order as $orderField ) {
			$order .= ', ' . $orderField;
		}
		$order = ltrim ( $order, ', ' );
		// end order
		
		// limit
		if (! empty ( $this->limit ))
			$limit = $this->limit ['min'] . ', ' . $this->limit ['max'];
		else
			$limit = '';
			// end limit
			
		// put everything together
		$query = '';
		if (trim ( $fields ) != '') {
			$query .= "SELECT {$fields} ";
		}
		if (trim ( $from ) != "") {
			$query .= "FROM {$from} ";
		}
		if (trim ( $join ) != '') {
			$query .= "{$join} ";
		}
		if (trim ( $where ) != '') {
			$query .= "WHERE {$where} ";
		}
		if (trim ( $group ) != '') {
			$query .= "GROUP BY {$group} ";
		}
		if (trim ( $having ) != '') {
			$query .= "HAVING {$having} ";
		}
		if (trim ( $order ) != '') {
			$query .= "ORDER BY {$order} ". $this->orderType;
		}
		if (trim ( $limit ) != '') {
			$query .= " LIMIT {$limit} ";
		}
		
		return array (
				'query' => $query,
				'exec' => $execArray 
		);
	}
}

?>