<?php

namespace Zwaldeck\View;

use Zwaldeck\Http\Response;

class View extends AbstractView {
	
	/**
	 * the controller name
	 * 
	 * @var string
	 */
	protected $_controller;
	
	/**
	 * the action name
	 * 
	 * @var string
	 */
	protected $_action;
	
	/**
	 *
	 * @param array $layout        	
	 * @param string $controller        	
	 * @param string $action        	
	 */
	public function __construct(array $layout = array(), $controller = 'index', $action = 'index') {
		parent::__construct ( $layout );
		
		$this->_controller = strtolower ( $controller );
		$this->_action = strtolower ( $action );
		
		$this->parseLayout ();
	}
	
	/**
	 * Creates and returns a response
	 *
	 * @param Response $response        	
	 * @return Response
	 */
	public function render(Response $response) {
		if(is_null($response))
			throw new \InvalidArgumentException('Response cannot be null');
		
		// set response
		extract ( $this->_variables );
		
		
		if (! empty ( $this->_viewRegistry )) {
			
			foreach ( $this->_viewRegistry as $view ) {
				if (file_exists ( ROOT . DS . 'Application' . DS . $view )) {
							ob_start ();
							require (ROOT . DS . 'Application' . DS . $view);
							$response->appendBody ( ob_get_contents  () );
							$e = ob_end_clean();
				} else
					throw new \Exception ( "({$view}) does not exist" );
			}
			
			
		} else {
			$response->appendBody ( require (ROOT . DS . 'Application' . DS . 'Views/' . $this->_controller . DS . $this->_action . '.phtml') );
		}
		
		return $response;
	}
	
	/**
	 * parses the layout
	 * 
	 * @see \Zwaldeck\View\AbstractView::parseLayout()
	 */
	protected function parseLayout() {
		$this->_viewRegistry = array ();
		
		if ($this->_layout != null) {
			foreach ( $this->_layout as $viewName => $viewFile ) {
				if (strtolower ( $viewName ) == 'content') {
					$this->_viewRegistry [$viewName] = 'Views/' . $this->_controller . '/' . $this->_action . '.phtml';
				} else {
					$this->_viewRegistry [$viewName] = $viewFile;
				}
			}
		}
	}
	
	/**
	 * Set a variable that can be used in a view template
	 * 
	 * @see \Zwaldeck\View\AbstractView::set()
	 */
	public function set($key, $value) {
		if(trim($key) == '' || !is_string($key))
			throw new \InvalidArgumentException('$key must be a valid not empty string');
		$this->_variables [$key] = $value;
	}
	
	/**
	 * gets a variable that can be used in a view template
	 * 
	 * @see \Zwaldeck\View\AbstractView::get()
	 */
	public function get($key) {
		if(trim($key) == '' || !is_string($key))
			throw new \InvalidArgumentException('$key must be a valid not empty string');
		
		if(!array_key_exists($key, $this->_variables))
			throw new \Exception("Registry does not have a key with value: {$key}");
		
		return $this->_variables [$key];
	}
}

?>