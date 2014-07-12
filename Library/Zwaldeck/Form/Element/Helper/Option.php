<?php

namespace Zwaldeck\Form\Element\Helper;

/**
 * Class Option
 * @package Zwaldeck\Form\Element\Helper
 * @author wout schoovaerts
 */
class Option {
	/**
	 * disabled attribute
	 * @var boolean
	 */
	private $disabled;
	
	/**
	 * selected attribute
	 * @var boolean
	 */
	private $selected;
	
	/**
	 * value attribute
	 * @var string
	 */
	private $value;
	
	/**
	 * text of the option
	 * @var string
	 */
	
	private $text;
	
	
	/**
	 * @param string $text
	 * @param boolean $disabled
	 * @param boolean $selected
	 * @param string $value
	 * @param string $label
	 * @throws \InvalidArgumentException
	 */
	public function __construct($text,$disabled = false, $selected = false ,$value = "") {
		if(!is_string($text)) {
			throw new \InvalidArgumentException('$text must be a valid string');
		}
		
		if(!is_string($value)) {
			throw new \InvalidArgumentException('$value must be a valid string');
		}
	
		if(!is_bool($disabled)) {
			throw new \InvalidArgumentException('$disabled must be a valid boolean');
		}
		
		if(!is_bool($selected)) {
			throw new \InvalidArgumentException('$selected must be a valid boolean');
		}
	
		$this->text = trim($text);
		$this->disabled = $disabled;
		$this->selected = $selected;
		$this->value = trim($value);
	}
	
	/**
	 * @return boolean
	 */
	public function getDisabled() {
		return $this->disabled;
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
	 * @return boolean
	 */
	public function getSelected() {
		return $this->selected;
	}
	
	/**
	 * @param boolean $selected
	 * @throws \InvalidArgumentException
	 */
	public function setSelected($selected) {
		if(!is_bool($selected)){
			throw new \InvalidArgumentException('$selected must true or false');
		}
		$this->selected = $selected;
	}
	
	/**
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}
	
	/**
	 * @param string $value
	 * @throws \InvalidArgumentException
	 */
	public function setValue($value) {
		if(!is_string($value)) {
			throw new \InvalidArgumentException('$value must be a valid string');
		}
	
		$this->value = $value;
	}
	
	/**
	 * @return string
	 */
	public function getText() {
		return $this->text;
	}

    /**
     * @param string $text
     * @throws \InvalidArgumentException
     */
    public function setText($text) {
		if(!is_string($text)) {
			throw new \InvalidArgumentException('$text must be a valid string');
		}
		
		$this->text = $text;
	}

    /**+
     * @return string
     */
    public function render() {
		$dis = $this->disabled ? 'disabled' : "";
		$sel = $this->selected ? 'selected' : "";
		
		return "<option {$sel} {$dis} value=\"{$this->value}\">{$this->text}</option>";
	}
	
}
?>