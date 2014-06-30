<?php

namespace Zwaldeck\Form\Element\Helper;

class OptGroup {
	
	/**
	 * disabled attribute
	 * @var boolean
	 */
	private $disabled;
	
	/**
	 * the label attribute
	 * @var string
	 */
	private $label;
	
	/**
	 * all options
	 * 
	 * key = value attribute
	 * value = text that will be showed
	 * 
	 * @var array
	 */
	private $options;
	
	/**
	 * @param string $disabled
	 * @param string $label
	 * @throws \InvalidArgumentException
	 */
	public function __construct($disabled = false, $label = "") {
		if(!is_string($label)) {
			throw new \InvalidArgumentException('$label must be a valid string');
		}
		
		if(!is_bool($disabled)) {
			throw new \InvalidArgumentException('$disabled must be a valid boolean');
		}
		
		$this->disabled = $disabled;
		$this->label = trim($label);
		$this->options = array();
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
	 * @return string
	 */
	public function getLabel() {
		return $this->label;
	}
	
	/**
	 * @param string $label
	 * @throws \InvalidArgumentException
	 */
	public function setLabel($label) {
		if(!is_string($label)) {
			throw new \InvalidArgumentException('$label must be a valid string');
		}
		
		$this->label = $label;
	}
	
	/**
	 * @return array
	 */
	public function getOptions() {
		return $this->options;
	}
	
	/**
	 * @param array $options
	 */
	public function setOptions(array $options) {
		$this->options = $options;
	}
	
	public function addOption(Option $option) {
		
		$this->options[] = $option;
	}
	
	public function render() {
		$dis = $this->disabled ? 'disabled' : "";
		$opt = "<optgroup label={$this->label} {$dis}>";
		
		foreach($this->options as $option) {
			if(!$option instanceof Option){
				throw new \Exception('All options must be off the object Zwaldeck\Form\Element\Helper\Option');
			}
			$opt .= $option->render();
		}
		
		$opt .= "</optgroup>";
		
		return $opt;
	}
}
?>