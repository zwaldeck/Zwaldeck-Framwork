<?php

namespace Zwaldeck\Router;

use Zwaldeck\Http\Response;
use Zwaldeck\Http\Request;
use Zwaldeck\Exception\ControllerNotFoundException;
use Zwaldeck\Exception\ActionNotFoundException;

/**
 * Here happens the dispatch
 * 
 * @author Wout Schoovaerts
 *        
 */
class Router {
	const DELIM = '/';
	
	/**
	 * the controller Postfix
	 * 
	 * @var string
	 */
	private $_controllerPostFix = 'Controller';
	
	/**
	 * the action Postfix
	 * 
	 * @var string
	 */
	private $_actionPostFix = 'Action';
	/**
	 * The full url
	 * 
	 * @var string
	 */
	private $url;
	
	/**
	 * the controller name
	 * 
	 * @var string
	 */
	private $controller;
	
	/**
	 * the action name
	 * 
	 * @var string
	 */
	private $action;
	
	/**
	 * here we store all the variables that go in the controller action
	 * 
	 * @var array
	 */
	private $variables;
	
	/**
	 *
	 * @param string $url        	
	 * @param array $layout        	
	 * @param Response $response        	
	 * @param Request $request        	
	 * @throws \InvalidArgumentException
	 */
	public function __construct($url, array $layout, Response $response, Request $request) {
		if (trim ( $url ) == '' || ! is_string ( $url ))
			throw new \InvalidArgumentException ( '$url must be a valid not empty string' );
		
		if (! is_array ( $layout ) || empty ( $layout )) {
			throw new \InvalidArgumentException ( 'Layout cannot be an empty array' );
		}
		
		if (is_null ( $response )) {
			throw new \InvalidArgumentException ( 'Reponse may not be null' );
		}
		
		if (is_null ( $request )) {
			throw new \InvalidArgumentException ( 'Request may not be null' );
		}
		
		$this->url = $url;
		$array = explode ( $this::DELIM, $url );
		$this->controller = ucfirst ( array_shift ( $array ) );
		$this->action = array_shift ( $array );
		if(is_null($this->action)|| trim($this->action) == '')
			$this->action = 'index';
		$this->variables = $array;
		
		$this->dispatch ( $layout, $response, $request );
	}
	
	/**
	 * We dispatch and excecute the controller action
	 * 
	 * @param array $layout        	
	 * @param Response $response        	
	 * @param Request $request        	
	 * @throws \Exception
	 */
	private function dispatch($layout, Response $response, Request $request) {
		$controllerName = 'Application\\Controllers\\' . $this->controller . $this->_controllerPostFix;
		if (class_exists ( $controllerName )) {
			$controllerIntance = new $controllerName ( $layout, $this->controller, $this->action, $response, $request );
			$methodName = $this->action . $this->_actionPostFix;
			
			if (method_exists ( $controllerIntance, $methodName )) {
				call_user_func_array ( array (
						$controllerIntance,
						$methodName 
				), $this->variables );
				call_user_func ( array (
						$controllerIntance,
						'finish' 
				) );
			} else {
				throw new ActionNotFoundException( "Action ({$this->action}) can not be found" );
			}
		} else {
			throw new ControllerNotFoundException("Controller ({$this->controller}) can not be found");
		}
	}
}

?>