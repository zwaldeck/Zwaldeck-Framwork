<?php

namespace Zwaldeck\Form\Element;

/**
 * Class DateElement
 * @package Zwaldeck\Form\Element
 * @author wout schoovaerts
 */
class DateElement extends AbstractElement {

    /**
     * @param string $id
     */
    public function __construct($id) {
		parent::__construct($id);
	}

    /**
     * @return string
     */
    public function render() {
		$attr = $this->renderAttr();
		$class = $this->renderClasses();
		$disabled = $this->disabled ? 'disabled' : '';
		$required = $this->required ? 'required' : '';
		
		return "<input type=\"date\" id=\"{$this->id}\" name=\"{$this->name}\" {$attr} {$class} {$disabled} {$required} value=\"{$this->value}\" />";
	}
}

?>