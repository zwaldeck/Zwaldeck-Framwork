<?php

namespace Zwaldeck\Http\GlobalHelper;

/**
 * This handels singel and multiple upload
 *
 * @author Wout Schoovaerts
 *        
 */
class Upload {
	
	/**
	 * array of names
	 * @var array
	 */
	protected $_names;
	
	/**
	 * array of types
	 * @var array
	 */
	protected $_types;
	
	/**
	 * array of tmp_name
	 * @var array
	 */
	protected $_tmp_names;
	
	/**
	 * array of errors
	 * @var array
	 */
	protected $_errors;
	
	/**
	 * array of size
	 * @var array
	 */
	protected $_sizes;
	
	/**
	 * @param array $file
	 */
	public function __construct(array $file) {
		$this->_names [] = $file ['name'];
		$this->_types [] = $file ['type'];
		$this->_tmp_names [] = $file ['tmp_name'];
		$this->_errors [] = $file ['error'];
		$this->_sizes [] = $file ['size'];
		
		
	}
	
	/**
	 * Return of the object has multiple upload or not
	 * 
	 * @return boolean
	 */
	public function isMultipleUpload() {
		return count ( $this->_names ) > 1;
	}
	
	/**
	 * returns all the names
	 * 
	 * @return array
	 */
	public function getNames() {
		return $this->_names;
	}
	
	/**
	 * returns an array of the types
	 * 
	 * @return array
	 */
	public function getTypes() {
		return $this->_types;
	}
	
	/**
	 * returns an array of the tmp names
	 * 
	 * @return array
	 */
	public function getTmpNames() {
		return $this->_tmp_names;
	}
	
	/**
	 * returns an array of the errors
	 * 
	 * @return array
	 */
	public function getErrors() {
		return $this->_errors;
	}
	
	/**
	 * returns an array of the sizes
	 * 
	 * @return array
	 */
	public function getSizes() {
		return $this->_sizes;
	}
}

?>