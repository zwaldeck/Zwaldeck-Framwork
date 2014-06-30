<?php

namespace Zwaldeck\Controller;

use Zwaldeck\Http\Request;
use Zwaldeck\Http\Response;
use Zwaldeck\View\View;

/**
 * 
 * @author Wout Schoovaerts
 */
class Controller {

	/**
	 * 
	 * @var View
	 */
	protected $_view;
	
	/**
	 * 
	 * @var string
	 */
	protected $_action;
	
	/**
	 * 
	 * @var string
	 */
	protected $_controller;
	
	/**
	 * 
	 * @var array
	 */
	protected $_layout;
	
	/**
	 * 
	 * @var Response
	 */
	private $_response;
	
	/**
	 * 
	 * @var Request
	 */
	private $_request;
	
	/**
	 * 
	 * @param array $layout
	 * @param string $controllerName
	 * @param string $actionName
	 * @param Response $response
	 * @param Request $request
	 * @throws \InvalidArgumentException
	 */
	public function __construct(array $layout, $controllerName, $actionName, Response $response, Request $request) {
		if(!is_array($layout) || !is_string($controllerName) || trim($controllerName) == '' || !is_string($actionName) || trim($actionName) == '' || is_null($request) || is_null($response))
			throw new \InvalidArgumentException('One of the arguments is wrong ');
		
		$this->_layout = $layout;
		$this->_controller = $controllerName;
		$this->_action = $actionName;
		
		$this->_response = $response;
		$this->_request = $request;
		
		$this->_view = new View($this->_layout, $this->_controller, $this->_action);
		
	}
	
	/**
	 * renders and sends the reponse
	 */
	public function finish() {
		$reponse = $this->_view->render($this->_response);
		$reponse->sendPage();
	}
	
	/**
	 * returns a response object
	 * @return \Zwaldeck\Http\Response
	 */
	public function getResponse() {
		return $this->_response;
	}
	
	/**
	 * returns a request object
	 * @return \Zwaldeck\Http\Request
	 */
	public function getRequest() {
		return $this->_request;
	}
	
	/**
	 * sets a new variable that you can use in the view template
	 * 
	 * @param string $key variable name
	 * @param mixed $value variable value
	 * @throws \InvalidArgumentException
	 */
	public function set($key, $value) {
		if(trim($key) == '' || ! is_string($key))
			throw new \InvalidArgumentException('$key cannot be empty and must be a string');
		
		$this->_view->set($key,$value);
	}
	
	/**
	 * returns the variable of the view
	 * 
	 * @param string $key variable name
	 * @return mixed
	 */
	public function get($key) {
		return $this->_view->get($key);
	}
}

?>