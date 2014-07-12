<?php

namespace Zwaldeck\Form;

/**
 * Class Label
 * @package Zwaldeck\Form
 * @author wout schoovaerts
 */
class Label {
	/**
	 * id off the element
	 * @var string
	 */
	private $id;
	
	/**
	 * for custom attributes or not comon used attributes
	 *
	 * if for example you have $attr['for'] and $for is set
	 * then name wil be rendered twice
	 * @var array
	 */
	private $attr;
	
	/**
	 * holds all the classes
	 * @var array
	 */
	private $classes;
	
	/**
	 * for attribute
	 * @var string
	 */
	private $for;
	
	/**
	 * text between the label
	 * @var $text
	 */
	private $text;

    /**
     * @param string $id
     * @param string $for
     * @param string $text
     * @throws \InvalidArgumentException
     */
    public function __construct($id, $for, $text) {
		if(!is_string($id) || trim($id) == "") {
			throw new \InvalidArgumentException('$id must be a string and not empty');
		}
		
		if(!is_string($for) || trim($for) == "") {
			throw new \InvalidArgumentException('$for must be a string and not empty');
		}
		
		if(!is_string($text) || trim($text) == "") {
			throw new \InvalidArgumentException('$text must be a string and not empty');
		}
	
		$this->id = $id;
		$this->for = $for;
		$this->text = $text;
		$this->attr = array();
		$this->classes = array();
	}
	
	/**
	 * @return string $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return array $attr
	 */
	public function getAttr() {
		return $this->attr;
	}

	/**
	 * @return string $for
	 */
	public function getFor() {
		return $this->for;
	}

	/**
	 * @return string $text
	 */
	public function getText() {
		return $this->text;
	}
	
	/**
	 * @return array
	 */
	public function getClasses() {
		return $this->classes;
	}
	
	/**
	 * @param array $attr
	 */
	public function setAttr(array $attr) {
		$this->attr = $attr;
	}

	/**
	 * @param string $for
	 * @throws \InvalidArgumentException
	 */
	public function setFor($for) {
		if(!is_string($for) || trim($for) == "") {
			throw new \InvalidArgumentException('$for must be a string and not empty');
		}
		$this->for = $for;
	}

	/**
	 * @param string $text
	 * @throws \InvalidArgumentException
	 */
	public function setText($text) {
		if(!is_string($text) || trim($text) == "") {
			throw new \InvalidArgumentException('$text must be a string and not empty');
		}
		$this->text = $text;
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
    public function addClass($name) {
		if(!is_string($name) || trim($name) == "") {
			throw new \InvalidArgumentException('$name must be a string and not empty');
		}
		
		$this->classes[] = $name;
	}

    /**
     * @return string
     */
    public function render() {
		$class = "class=\"";
		foreach($this->classes as $className) {
			$class .= $className." ";
		}
		$class = rtrim($class)."\"";
		
		$attr = "";
		foreach($this->attr as $name => $value) {
			$attr .= $name."=\"{$value}\" ";
		}
		$attr = rtrim($attr);
		
		return "<label id=\"{$this->id}\" for=\"{$this->for}\" {$attr} {$class}>{$this->text}</label>";
		
	}
}
?>