<?php

namespace Zwaldeck\Form\Element;

/**
 * Class HiddenElement
 * @package Zwaldeck\Form\Element
 * @author wout schoovaerts
 */
class HiddenElement extends AbstractElement {

	/**
	 * @param unknown $id
	 * @param string $value
	 * @throws \InvalidArgumentException
	 */
	public function __construct($id, $value = "") {
		if(!is_string($value)) {
			throw new \InvalidArgumentException('$value must be a valid string');
		}
		
		parent::__construct($id);
		
		$this->value = $value;
	}

    /**
     * @return string
     */
    public function render() {
		$attr = $this->renderAttr();
		$class = $this->renderClasses();
		return "<input type=\"hidden\" id=\"{$this->id}\" name=\"{$this->name}\" {$attr} {$class} value=\"{$this->value}\" />";
	}
}

?>