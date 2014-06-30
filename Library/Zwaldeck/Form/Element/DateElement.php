<?php

namespace Zwaldeck\Form\Element;

use Zwaldeck\Exceptoin\NotImplementedYet;
class DateElement extends AbstractElement {
	
	public function __construct($id) {
		parent::__construct($id);
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
		$disabled = $this->disabled ? 'disabled' : '';
		$required = $this->required ? 'required' : '';
		
		return "<input type=\"date\" id=\"{$this->id}\" name=\"{$this->name}\" {$attr} {$class} {$disabled} {$required} value=\"{$this->value}\" />";
	}
}

?>