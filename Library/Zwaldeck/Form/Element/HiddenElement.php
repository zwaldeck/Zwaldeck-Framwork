<?php

namespace Zwaldeck\Form\Element;

use Zwaldeck\Exception\NotImplementedYet;
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
	 * @throws NotImplementedYet
	 */
	public function validate() {
		throw new NotImplementedYet();
	}
	
	public function render() {
		$attr = $this->renderAttr();
		$class = $this->renderClasses();
		return "<input type=\"hidden\" id=\"{$this->id}\" name=\"{$this->name}\" {$attr} {$class} value=\"{$this->value}\" />";
	}
}

?>