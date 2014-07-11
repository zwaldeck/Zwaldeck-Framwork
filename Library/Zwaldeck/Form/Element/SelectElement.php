<?php

namespace Zwaldeck\Form\Element;

use Zwaldeck\Exception\NotImplementedYet;
use Zwaldeck\Form\Element\Helper\OptGroup;
use Zwaldeck\Form\Element\Helper\Option;
class SelectElement extends AbstractElement {
	
	/**
	 * All the optGroups
	 * @var array of OptGroup objects
	 */
	private $optGroups;
	
	/**
	 * All the options that are not in an optgroup
	 * @var array of Option Objects
	 */
	private $options;
	
	/**
	 * autofocus atrribute
	 * @var boolean
	 */
	private $autofocus;
	
	/**
	 * multiple attribute
	 * @var boolean
	 */
	private $multiple;
	
	/**
	 * Size attribute
	 * 
	 * Default = 0 means size attribute does not get rendered
	 * @var integer
	 */
	private $size;
	
	/**
	 * @param string $id
	 */
	public function __construct($id,$multiple = false, $size = 0, $autofocus = false) {
		parent::__construct($id);
		
		$this->optGroups = array();
		$this->options = array();
		$this->autofocus = $autofocus;
		$this->multiple = $multiple;
		$this->size = $size;
	}
	
	/**
	 * @return array
	 */
	public function getOptGroups() {
		return $this->optGroups;
	}
	
	/**
	 * @param array $optgroups
	 */
	public function setOptGroups(array $optgroups) {
		$this->optGroups = $optgroups;
	}
	
	/**
	 * @param OptGroup $optgroup
	 */
	public function addOptGroup(OptGroup $optgroup) {
		$this->optGroups[] = $optgroup;
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
	
	/**
	 * @param Option $option
	 */
	public function addOption(Option $option) {
		$this->options[] = $option;
	}
	
	/**
	 * @return boolean
	 */
	public function getAutoFocus() {
		return $this->autofocus;
	}

	/**
	 * @param boolean $autoFocus
	 * @throws \InvalidArgumentException
	 */
	public function setAutoFocus($autoFocus) {
		if(!is_bool($autoFocus)) {
			throw new \InvalidArgumentException('$autofocus must be true or false');
		}
		
		$this->autofocus = $autoFocus;
	}
	
	/**
	 * @return boolean
	 */
	public function getMultiple() {
		return $this->multiple;
	}
	
	/**
	 * @param boolean $multiple
	 * @throws \InvalidArgumentException
	 */
	public function setMultiple($multiple) {
		if(!is_bool($multiple)) {
			throw new \InvalidArgumentException('$multiple must be true or false');
		}
	
		$this->multiple = $multiple;
	}
	
	/**
	 * @return integer
	 */
	public function getSize() {
		return $this->size;
	}
	
	/**
	 * @param number $size
	 */
	public function setSize($size) {
		if(!is_int($size)) {
			throw new \InvalidArgumentException('$size must be an integer');
		}
		$this->size = $size;
	}
	
	/**
	 * @throws NotImplementedYet
	 */
	public function validate() {
		throw new NotImplementedYet();	
	}
	
	public function render() {
		$size = $this->size == 0 ? '' : 'size="'.$this->size.'"';
		$attr = $this->renderAttr();
		$class = $this->renderClasses();
		$required = $this->required ? 'required' : '';
		$disabled = $this->disabled ? 'disabled' : '';
		$auto = $this->autofocus ? 'autofocus' : '';
		$multi = $this->multiple ? 'multiple' : '';
		
		$sel = "<select id=\"{$this->id}\" name=\"{$this->name}\" {$attr} {$class} {$size} {$required} {$disabled} {$auto} {$multi}>";
		
		foreach ($this->options as $option) {
			$sel .= $option->render();
		}
		
		foreach($this->optGroups as $optGroup) {
			$sel .= $optGroup->render();
		}
		
		$sel .= "</select>";
		
		return $sel;
	}
}

?>