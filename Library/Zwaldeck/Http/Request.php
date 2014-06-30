<?php

namespace Zwaldeck\Http;

use Zwaldeck\Http\GlobalHelper\Upload;
class Request {
	const METHOD_HEAD = 'HEAD';
	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	const METHOD_PATCH = 'PATCH';
	const METHOD_DELETE = 'DELETE';
	
	/**
	 * 
	 * @var string
	 */
	protected $_method;
	
	// Request params
	/**
	 * $_SEVER alias
	 * @var array
	 */
	protected $_headers = array (); // $_SERVER alias
	/**
	 * $_POST alias
	 * @var array
	 */
	protected $_postParams = array ();
	
	/**
	 * $_GET alias
	 * @var array
	 */
	protected $_getParams = array ();
	
	/**
	 * $_FILES alias
	 * @var array
	 */
	protected $_filesParams = array();
	
	/**
	 * the requested url
	 * @var array
	 */
	protected $_url;
	
	/**
	 * all the parameters in a string
	 * @var string
	 */
	protected $_rawParams;
	
	/**
	 * upload classes
	 * @var array
	 */
	protected $_uploads;
	
	/**
	 * @param string $method
	 * @param string $url
	 * @param array $headers
	 * @param string $rawContent
	 */
	public function __construct($method = "", $url = "", array $headers = array(), $rawContent = "") {
		$this->_method = $method;
		$this->_url = $url;
		$this->_headers = $headers;
		$this->_rawParams = $rawContent;
		
		$this->_postParams = $_POST;
		$this->_getParams = $_GET;
		$this->_filesParams = $_FILES;
		
		foreach($_FILES as $fieldname => $file) {
			$this->_uploads[$fieldname] = new Upload($file);
		}
	}
	
	/**
	 * returns the request headers
	 * @return array
	 */
	public function getHeaders() {
		return $this->headers;
	}
	
	/**
	 * returns a specific request header
	 * @param string $key
	 * @return mixed:
	 * @throws \InvalidArgumentException
	 * @throws \Exception
	 */
	public function getHeader($key) {
		if(!is_string($key) || trim($key) == '')
			throw new \InvalidArgumentException('$key must be a valid string');
		
		if(!array_key_exists($key, $this->_headers))
			throw new \Exception("Headers does not have a key with value: {$key}");
		
		return $this->_headers [$key];
	}
	
	/**
	 * check if methos is post
	 * @return boolean
	 */
	public function isPost() {
		return strtoupper ( $this->_method ) == self::METHOD_POST;
	}
	
	/**
	 * check if methos is get
	 * @return boolean
	 */
	public function isGet() {
		return strtoupper ( $this->_method ) == self::METHOD_GET;
	}
	
	/**
	 * check if methos is head
	 * @return boolean
	 */
	public function isHead() {
		return strtoupper ( $this->_method ) == self::METHOD_HEAD;
	}
	
	/**
	 * check if methos is put
	 * @return boolean
	 */
	public function isPut() {
		return strtoupper ( $this->_method ) == self::METHOD_PUT;
	}
	
	/**
	 * check if methos is patch
	 * @return boolean
	 */
	public function isPatch() {
		return strtoupper ( $this->_method ) == self::METHOD_PATCH;
	}
	
	/**
	 * check if methos is delete
	 * @return boolean
	 */
	public function isDelete() {
		return strtoupper ( $this->_method ) == self::METHOD_DELETE;
	}
	
	public function isUpload() {
		foreach ($this->_filesParams as $file) {
			if(trim($file['tmp_name']) != "")
				return true;
		}
		
		return false;
	}
	
	/**
	 * returns the post parameters
	 * @return array
	 */
	public function getPost() {
		return $this->_postParams;
	}
	
	/**
	 * returns a specific post parameters
	 * 
	 * @var string
	 * @return mixed
	 * @throws \InvalidArgumentException
	 * @throws \Exception
	 */
	public function getPostParam($key) {
		if(!is_string($key) || trim($key) == '')
			throw new \InvalidArgumentException('$key must be a valid string');
		
		if(!array_key_exists($key, $this->_postParams))
			throw new \Exception("Post does not have a key with value: {$key}");
		
		return $this->_postParams [$key];
	}
	
	/**
	 * returns the get parameters
	 * @return array
	 */
	public function getQuery() {
		return $this->_getParams;
	}
	
	/**
	 * returns a specific get parameters
	 *
	 * @var string
	 * @return mixed
	 * @throws \InvalidArgumentException
	 * @throws \Exception
	 */
	public function getQueryParam($key) {
		
		if(!is_string($key) || trim($key) == '')
			throw new \InvalidArgumentException('$key must be a valid string');
		
		if(!array_key_exists($key, $this->_getParams))
			throw new \Exception("Query does not have a key with value: {$key}");
		
		return $this->_getParams [$key];
	}
	
	
	/**
	 * returns the post parameters
	 * @return array
	 */
	public function getPut() {
		return $this->getPost ();
	}
	
	/**
	 * returns a specific post parameters
	 *
	 * @var string
	 * @return mixed
	 * @throws \InvalidArgumentException
	 * @throws \Exception
	 */
	public function getPutParam($key) {
		if(!is_string($key) || trim($key) == '')
			throw new \InvalidArgumentException('$key must be a valid string');
		
		if(!array_key_exists($key, $this->_postParams))
			throw new \Exception("Post does not have a key with value: {$key}");
		
		return $this->getPostParam ( $key );
	}
	
	/**
	 * returns the post parameters
	 * @return array
	 */
	public function getDelete() {
		return $this->getPost ();
	}
	
	/**
	 * returns a specific post parameters
	 *
	 * @var string
	 * @return mixed
	 * @throws \InvalidArgumentException
	 * @throws \Exception
	 */
	public function getDeleteParam($key) {
		if(!is_string($key) || trim($key) == '')
			throw new \InvalidArgumentException('$key must be a valid string');
		
		if(!array_key_exists($key, $this->_postParams))
			throw new \Exception("Post does not have a key with value: {$key}");
		
		return $this->getPostParam ( $key );
	}
	
	/**
	 * returns the post parameters
	 * @return array
	 */
	public function getPatch() {
		return $this->getPost ();
	}
	
	/**
	 * returns a specific post parameters
	 *
	 * @var string
	 * @return mixed
	 * @throws \InvalidArgumentException
	 * @throws \Exception
	 */
	public function getpatchParam($key) {
		if(!is_string($key) || trim($key) == '')
			throw new \InvalidArgumentException('$key must be a valid string');
		
		if(!array_key_exists($key, $this->_postParams))
			throw new \Exception("Post does not have a key with value: {$key}");
		
		return $this->getPostParam ( $key );
	}
	
	/**
	 * returns the get parameters
	 * @return array
	 */
	public function getHead() {
		return $this->getQuery ();
	}
	
	/**
	 * returns a specific get parameters
	 *
	 * @var string
	 * @return mixed
	 * @throws \InvalidArgumentException
	 * @throws \Exception
	 */
	public function getHeadParam($key) {
		
		if(!is_string($key) || trim($key) == '')
			throw new \InvalidArgumentException('$key must be a valid string');
		
		if(!array_key_exists($key, $this->_getParams))
			throw new \Exception("Query does not have a key with value: {$key}");
		
		return $this->getQueryParam ( $key );
	}
	
	/**
	 * returns an array off Upload objects
	 * @return array
	 */
	public function getUploadObjects() {
		return $this->_uploads();
	}
	
	public function getUploadObject($fieldname) {
		if(!is_string($fieldname) || trim($fieldname) == '')
			throw new \InvalidArgumentException('$fieldname must be a valid string');
		
		if(!array_key_exists($fieldname, $this->_uploads))
			throw new \Exception("Query does not have a key with value: {$fieldname}");
		
		return $this->_uploads[$fieldname];
	}
	
	/**
	 * retuns the $_FILES
	 * @return array
	 */
	public function getRawUpload() {
		return $this->_filesParams;
	}
	
	/**
	 * check if request is an ajax request
	 * @return boolean
	 */
	public function isAjax() {
		if (key_exists ( 'HTTP_X_REQUESTED_WITH', $this->_headers )) {
			if ($this->_headers ['HTTP_X_REQUESTED_WITH'] != '') {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * returns post when request is ajax
	 *
	 * @return array
	 */
	public function getAjax() {
		if ($this->isAjax ()) {
			return $this->getPost ();
		}
		
		return null;
	}
	
	/**
	 * check if it is HTTPS
	 * @return boolean
	 */
	public function isSecure() {
		if($this->_headers['REQUEST_SCHEME'] == 'https')
			return true;
		
		return false;
	}
}

?>