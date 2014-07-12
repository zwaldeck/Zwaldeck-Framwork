<?php

namespace Zwaldeck\Form\Element;

use Zwaldeck\Exception\NotImplementedYet;

class FileElement extends AbstractElement{
	
	/**
	 * multiple attribute
	 * @var boolean
	 */
	private $multiple;
	
	/**
	 * Size attr default = 0
	 * @var integer
	 */
	private $size;
	
	public function __construct($id, $multiple = false ,$size = 0) {
		parent::__construct($id);
		
		$this->multiple = $multiple;
		$this->size = $size;
	}
	
	/**
	 * @return boolean
	 */
	public function isMultiple() {
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
	
	public function getSize() {
		return $this->size;
	}
	
	/**
	 * @param integer $size
	 * @throws \InvalidArgumentException
	 */
	public function setSize($size) {
		if(!is_int($size)) {
			throw new \InvalidArgumentException('$size must be an integer');
		}
		
		$this->size = $size;
	}
	
	public function render() {
		$size = $this->size == 0 ? '' : 'size="'.$this->size.'"';
		$attr = $this->renderAttr();
		$class = $this->renderClasses();
		$required = $this->required ? 'required' : '';
		$disabled = $this->disabled ? 'disabled' : '';
		$multi = $this->multiple ? 'multiple' : '';
		
		return "<input type=\"file\" id=\"{$this->id}\" name=\"{$this->name}\" {$attr} {$class} {$size} {$required} {$disabled} {$multi} >";
	}
}

?>