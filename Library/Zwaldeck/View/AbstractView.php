<?php

namespace Zwaldeck\View;

use Zwaldeck\Http\Response;
/**
 * The abstract view class
 * @author Wout Schoovaerts
 *
 */
abstract class AbstractView {
	
	/**
	 * this array had the views it must render
	 * 
	 * MUST contain CONTENT
	 * @var array
	 */
	protected $_layout;
	
	/**
	 * Holds all the content
	 * 
	 * @var array
	 */
	protected $_viewRegistry;
	
	/**
	 *  Holds all the variables that can be used in the view template
	 * @var array
	 */
	protected $_variables = array();
	
	/**
	 * 
	 * @param array $layout
	 * @throws \Exception
	 */
	protected function __construct(array $layout = array()) {
		$this->_layout = $layout;
		
		if(empty($this->_layout)) {
			throw new \Exception("Layout can not be empty, Must at least contain content value");
		}
	}
	
	/**
	 * Parses the layout
	 */
	protected abstract function parseLayout();
	
	/**
	 * @param Response $response
	 */
	public abstract function render(Response $response); 
	
	/**
	 * 
	 * @param string $key
	 * @param mixed $value
	 */
	public abstract function set($key, $value);
	
	/**
	 * @param string $key
	 */
	public abstract function get($key);
}

?>