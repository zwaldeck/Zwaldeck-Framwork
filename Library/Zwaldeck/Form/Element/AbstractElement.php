<?php

namespace Zwaldeck\Form\Element;

use Zwaldeck\Form\Label;
abstract class AbstractElement {
	
	/**
	 * id off the element
	 * @var string
	 */
	protected $id;
	
	/**
	 * for custom attributes or not comon used attributes
	 * 
	 * if for example you have $attr['name'] and $name isset
	 * then name wil be rendered twice
	 * @var array
	 */
	protected $attr;
	
	/**
	 * name off the element
	 * 
	 * default = id
	 * @var string
	 */
	protected $name;
	
	/**
	 * required or not
	 * @var boolean
	 */
	protected $required;

	/**
	 * all the css classes
	 * @var array
	 */
	protected $classes;
	
	/**
	 * disabled or not
	 * @var boolean
	 */
	protected $disabled;
	
	/**
	 * the value off the element
	 * @var mixed
	 */
	protected $value;
	
	/**
	 * the label
	 * @var Zwaldeck\Form\Label
	 */
	protected $label;
	
	/**
	 * 
	 * @param string $id can only be set in constructor
	 * @throws \InvalidArgumentException
	 */
	public function __construct($id) {
		if(!is_string($id) || trim($id) == "") {
			throw new \InvalidArgumentException('$id must be a string and not empty');
		}
		
		$this->id = $id;
		$this->name = $id;
		
		$this->attr = array();
		$this->required = false;
		$this->classes = array();
		$this->disabled = false;
		$this->value = "";
		$this->label = null;
	}
	
	abstract function render();
	abstract function validate();
	
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $attr
	 */
	public function getAttr() {
		return $this->attr;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $required
	 */
	public function getRequired() {
		return $this->required;
	}

	/**
	 * @return the $classes
	 */
	public function getClasses() {
		return $this->classes;
	}

	/**
	 * @return the $disabled
	 */
	public function getDisabled() {
		return $this->disabled;
	}

	/**
	 * @return the $value
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @return the $label
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @param multitype: $attr
	 * @throws \InvalidArgumentException
	 */
	public function setAttr($attr) {
		if(!is_string($attr) || trim($attr) == "") {
			throw new \InvalidArgumentException('$attr must be a string and not empty');
		}
		$this->attr = $attr;
	}
	
	/**
	 * if key exists it overrides
	 *
	 * @param string $name
	 * @param string $value
	 * @throws \InvalidArgumentException
	 */
	public function addAttribute($name, $value) {
	
		if(!is_string($name) || trim($name) == "") {
			throw new \InvalidArgumentException('$name must be a string and not empty');
		}
	
		if(!is_string($value) || trim($value) == "") {
			throw new \InvalidArgumentException('$value must be a string and not empty');
		}
	
		$this->attr[$name] = $value;
	}

	/**
	 * @param string $name
	 * @throws \InvalidArgumentException
	 */
	public function setName($name) {
		if(!is_string($name) || trim($name) == "") {
			throw new \InvalidArgumentException('$name must be a string and not empty');
		}
		$this->name = $name;
	}

	/**
	 * @param boolean $required
	 * @throws \InvalidArgumentException
	 */
	public function setRequired($required) {
		if(!is_bool($required)){
			throw new \InvalidArgumentException('$required must true or false');
		}
		
		$this->required = $required;
	}

	/**
	 * @param string $classes
	 * @throws \InvalidArgumentException
	 */
	public function setClasses($classes) {
		if(!is_string($classes) || trim($classes) == "") {
			throw new \InvalidArgumentException('$classes must be a string and not empty');
		}
		$this->classes = $classes;
	}
	
	/**
	 * @param string $name
	 * @throws \InvalidArgumentException
	 */
	public function addClass($name) {
		if(!is_string($name) || trim($name) == "") {
			throw new \InvalidArgumentException('$name must be a string and not empty');
		}
	
		$this->classes[] = $name;
	}

	/**
	 * @param boolean $disabled
	 * @throws \InvalidArgumentException
	 */
	public function setDisabled($disabled) {
		if(!is_bool($disabled)){
			throw new \InvalidArgumentException('$disabled must true or false');
		}
		$this->disabled = $disabled;
	}

	/**
	 * @param string $value
	 * @throws \InvalidArgumentException
	 */
	public function setValue($value) {
		if(!is_string($value)) {
			throw new \InvalidArgumentException('$value must be a string and not empty');
		}
		$this->value = trim($value);
	}

	/**
	 * @param \Zwaldeck\Form\Element\Zwaldeck\Form\Label $label
	 */
	public function setLabel(Label $label) {
		$this->label = $label;
	}
	
	/**
	 * Renders the custom attributes
	 * @return string
	 */
	protected function renderAttr() {
		$attr = "";
		foreach($this->attr as $name => $value) {
			$attr .= $name."=\"{$value}\" ";
		}
		$attr = rtrim($attr);
		
		return $attr;
	}
	
	/**
	 * Renders the class atrribute
	 * @return string
	 */
	protected function renderClasses() {
		$class = "class=\"";
		foreach($this->classes as $className) {
			$class .= $className." ";
		}
		$class = rtrim($class)."\"";
		
		return $class;
	}
}
?>