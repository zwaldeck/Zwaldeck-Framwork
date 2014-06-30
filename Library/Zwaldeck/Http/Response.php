<?php

namespace Zwaldeck\Http;

/**
 * The response object
 * @author Wout Schoovaerts
 *
 */
class Response {
	
	/**
	 * All Status codes with corresponding text
	 * @var array
	 */
	public static $http_codes = array (
			100 => 'Continue',
			101 => 'Switching Protocols',
			102 => 'Processing',
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			207 => 'Multi-Status',
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			306 => 'Switch Proxy',
			307 => 'Temporary Redirect',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			418 => 'I\'m a teapot',
			422 => 'Unprocessable Entity',
			423 => 'Locked',
			424 => 'Failed Dependency',
			425 => 'Unordered Collection',
			426 => 'Upgrade Required',
			449 => 'Retry With',
			450 => 'Blocked by Windows Parental Controls',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported',
			506 => 'Variant Also Negotiates',
			507 => 'Insufficient Storage',
			509 => 'Bandwidth Limit Exceeded',
			510 => 'Not Extended' 
	);
	
	/**
	 *	status code of the response
	 * @var int
	 */
	private $statusCode;
	
	/**
	 * body of the repsonse
	 * @var string
	 */
	private $body;
	
	/**
	 *	length of the body
	 * @var int
	 */
	private $contentLenght;
	
	/**
	 * all headers that goes along with the response
	 * @var array
	 */
	private $headers; //$_SERVER alias
	
	/**
	 * all the cookies that goes along with the response
	 * @var array
	 */
	private $cookies;
	
	/**
	 * The protocol of the response
	 * Default: 'HTTP/1.1'
	 * @var string
	 */
	private $protocol =  "HTTP/1.1";
	
	/**
	 * the content type
	 * Default: 'text/html'
	 * @var string
	 */
	protected $_contentType = "text/html";
	
	/**
	 * the encoding
	 * Default: 'UTF-8' 
	 * @var string
	 */
	protected $_encoding = "UTF-8";
	
	/**
	 * @param string $body
	 * @param number $status
	 * @param array $headers
	 * @param array $cookies
	 */
	public function __construct($body = '', $status = 200, array $headers = array(), array $cookies = array()) {
		$this->body = $body;
		$this->statusCode = $status;
		$this->headers = $headers;
		$this->cookies = $cookies;
	}
	
	
	/**
	 * sets the body
	 * @param string $body
	 * @throws \InvalidArgumentException
	 */
	public function setBody($body) {
		if(!is_string($body) || trim($body) == '')
			throw new \InvalidArgumentException('Your view is wrong.');
		
		$this->body = $body;
	}
	
	/**
	 * appends to the body
	 * @param string $appendText
	 * @throws \InvalidArgumentException
	 */
	public function appendBody($appendText) {
		if(!is_string($appendText) || trim($appendText) == '')
			throw new \InvalidArgumentException('$body must be a valid string');
		
		$this->body .= $appendText;
	}
	
	/**
	 * returns the whole body
	 * @return string
	 */
	public function getBody() {
		return $this->body;
	}
	
	/**
	 *  set the status code
	 * @param integer $statusCode
	 * @throws \InvalidArgumentException
	 */
	public function setStatusCode($statusCode) {
		if(!is_int($statusCode))
			throw new \InvalidArgumentException('$body must be a valid integer');
		
		$this->statusCode = $statusCode;
	}
	
	/**
	 * returns the status code
	 * @return integer
	 */
	public function getStatusCode() {
		return $this->getStatusCode();
	}
	
	
	/**
	 * set all the headers
	 * @param array $headers
	 */
	public function setHeaders(array $headers) {
		$this->headers = $headers;
	}
	
	/**
	 * returns all the headers
	 * @return array
	 */
	public function getHeaders() {
		return $this->headers;
	}
	
	/**
	 * set a specific header
	 * @param string $key
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 * @throws \Exception
	 */
	public function addHeader($key, $value) {
		if(!is_string($key) || trim($key) == '')
			throw new \InvalidArgumentException('$key must be a valid string');
		
		if(!array_key_exists($key, $this->_headers))
			throw new \Exception("Headers does not have a key with value: {$key}");
		
		$this->headers[$key] = $value;
	}
	
	/**
	 * get a specific header
	 * @param string $key
	 * @return mixed
	 * @throws \InvalidArgumentException
	 * @throws \Exception
	 */
	public function getHeader($key) {
		if(!is_string($key) || trim($key) == '')
			throw new \InvalidArgumentException('$key must be a valid string');
		
		if(!array_key_exists($key, $this->_headers))
			throw new \Exception("Headers does not have a key with value: {$key}");
		
		return $this->headers[$key];
	}
	
	/**
	 * Cookies
	 * 
	 * After a while it needs his own class
	 */
	
	/**
	 * sets all the cookies
	 * @param array $cookies
	 */
	public function setCookies(array $cookies) {
		$this->cookies = $cookies;
	}
	
	/**
	 * returns all the cookies
	 * @return array
	 */
	public function getCookies() {
		return $this->cookies();
	}
	
	/**
	 * adds one cookie to the stack of cookies
	 * @param string $key
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 * @throws \Exception
	 */
	public function addCookie($key, $value) {
		if(!is_string($key) || trim($key) == '')
			throw new \InvalidArgumentException('$key must be a valid string');
		
		if(!array_key_exists($key, $this->cookies))
			throw new \Exception("Cookies does not have a key with value: {$key}");
		
		$this->cookies[$key] = $value;
	}
	
	/**
	 * retuns a specific cookie
	 * @param string $key
	 * @return mixed
	 * @throws \InvalidArgumentException
	 * @throws \Exception
	 */
	public function getCookie($key) {
		if(!is_string($key) || trim($key) == '')
			throw new \InvalidArgumentException('$key must be a valid string');
		
		if(!array_key_exists($key, $this->cookies))
			throw new \Exception("Cookies does not have a key with value: {$key}");
		
		return $this->cookies[$key];
	}
	
	/*
	 * Send functions
	 */
	
	/**
	 * send the status
	 */
	protected function sendStatus()
	{
		// Send HTTP Header
		header($this->protocol . " " . $this->statusCode . " " . self::$http_codes[$this->statusCode]);
	}
	
	/**
	 * sends all the headers
	 */
	protected function sendHeaders() {
		if(isset($this->_contentType))
			header('Content-Type: ' .$this->_contentType.'; charset='.$this->_encoding);
		
		foreach($this->headers as $headerKey => $headerValue) {
			if(!is_null($headerValue)) {
				header($headerKey.": ".$headerValue);
			}
		}
	}
	
	/**
	 * sends the body
	 */
	protected function sendBody() {
		echo $this->body;
	}
	
	/**
	 * send the whole page status, header and body
	 */
	public function sendPage() {
		if(session_id()) {
			session_write_close();
		}
		
		if(!headers_sent()) {
			$this->sendStatus();
			$this->sendHeaders();
		}
		
		$this->sendBody();
	}
}
?>