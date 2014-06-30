<?php

namespace Zwaldeck\Form\Element\Text;

use Zwaldeck\Form\Element\AbstractElement;

abstract class AbstractTextElement extends AbstractElement {
	
	/**
	 * is the elemend only readable or not
	 * @var boolean
	 */
	protected $readonly;
	
	/**
	 * maxlength off the element
	 * 
	 * 0 means infinity
	 * @var integer
	 */
	protected $maxlenght;
	
	/**
	 * the placeholder
	 * @var string
	 */
	protected $placeholder;
	
	public function __construct($id) {
		parent::__construct($id);
		$this->readonly = false;
		$this->maxlenght = 0;
		$this->placeholder = "";
	}
	
	/**
	 * @return boolean
	 */
	public function getReadonly() {
		return $this->readonly;
	}

	/**
	 * @return integer
	 */
	public function getMaxlenght() {
		return $this->maxlenght;
	}
	
	/**
	 * @return string
	 */
	public function getPlaceholder() {
		return $this->placeholder;
	}

	/**
	 * @param boolean $readonly
	 * @throws \InvalidArgumentException
	 */
	public function setReadonly($readonly) {
		if(!is_bool($readonly)) {
			throw new \InvalidArgumentException('$readonly must be true or false');
		}
		
		$this->readonly = $readonly;
	}

	/**
	 * @param number $maxlenght
	 * @throws \InvalidArgumentException
	 */
	public function setMaxlenght($maxlenght) {
		if(!is_int($maxlenght)) {
			throw new \InvalidArgumentException('$readonly must be an integer');
		}
		$this->maxlenght = $maxlenght;
	}
	
	/**
	 * @param unknown $placeholder
	 * @throws \InvalidArgumentException
	 */
	public function setPlaceholder($placeholder) {
		if(!is_string($placeholder)) {
			throw new \InvalidArgumentException('$placeholder must be a string');
		}
		
		$this->placeholder = trim($placeholder);
	}
}

?>