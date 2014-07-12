<?php

namespace Zwaldeck\Form\Element;

/**
 * Class ButtonElement
 * @package Zwaldeck\Form\Element
 * @author wout schoovaerts
 */
class ButtonElement extends AbstractElement {

	/**
	 * the autofocus attribute
	 * @var boolean
	 */
	private $autofocus;
	
	/**
	 * Type attribute
	 * @var string
	 */
	private $type;
	
	public static $allowedTypes = array(
		'button',
		'submit',
		'reset'
	);
	
	/**
	 * 
	 * @param string $id
	 * @param string $value
	 * @param string $type
	 * @param boolean $disabled
	 * @param boolean $autofocus
	 * @throws \InvalidArgumentException
	 */
	public function __construct($id, $value = "", $type="button", $disabled = false, $autofocus = false) {
		parent::__construct($id);
		
		if(!is_string($value)) {
			throw new \InvalidArgumentException('$value must be a valid string');
		}
		
		if(!in_array($type, self::$allowedTypes)) {
			throw new \InvalidArgumentException('$type must be one off the types of array ButtonElement::allowedTypes');
		}
		
		if(!is_bool($disabled)) {
			throw new \InvalidArgumentException('$disalbed must be true or false');
		}
		
		if(!is_bool($autofocus)) {
			throw new \InvalidArgumentException('$autofocus must be true or false');
		}
		
		$this->value = $value;
		$this->type = $type;
		$this->disabled = $disabled;
		$this->autofocus = $autofocus;
	}
	
	
	
	/**
	 * @return boolean
	 */
	public function getAutofocus() {
		return $this->autofocus;
	}

	/**
	 * @param boolean $autofocus
	 * @throws \InvalidArgumentException
	 */
	public function setAutofocus($autofocus) {
		if(!is_bool($autofocus)) {
			throw new \InvalidArgumentException('$autofocus must be true or false');
		}
		$this->autofocus = $autofocus;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $type
	 * @throws \InvalidArgumentException
	 */
	public function setType($type) {
		if(!in_array($type, self::$allowedTypes)) {
			throw new \InvalidArgumentException('$type must be one off the types of array ButtonElement::allowedTypes');
		}
		$this->type = $type;
	}

    /**
     * @return string
     */
    public function validate() {
		//Does Nothing in this element
		return "";
	}

    /**
     * @return string
     */
    public function render() {
		$attr = $this->renderAttr();
		$class = $this->renderClasses();
		$disabled = $this->disabled ? 'disabled' : '';
		$auto = $this->autofocus ? 'autofocus' : '';
		
		return "<button id=\"{$this->id}\" name=\"{$this->name}\" type=\"{$this->type}\" {$attr} {$class} {$disabled} {$auto}>{$this->value}</button>";
	}
}

?>