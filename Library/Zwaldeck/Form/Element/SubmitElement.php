<?php
namespace Zwaldeck\Form\Element;

/**
 * Class SubmitElement
 * @package Zwaldeck\Form\Element
 * @author wout schoovaerts
 */
class SubmitElement extends AbstractElement{
	
	/**
	 * @param string $id
	 * @param string $value
	 * @param boolean $disabled
	 * @throws \InvalidArgumentException
	 */
	public function __construct($id, $value = "" ,$disabled = false) {
		if(!is_string($value)) {
			throw new \InvalidArgumentException('$value must be a valid string');
		}
		
		if(!is_bool($disabled)) {
			throw new \InvalidArgumentException('$disabled must be true or false');
		}


		$this->value = $value;
		$this->disabled = $disabled;

	}

    /**
     * @return string
     */
    public function render() {
		$attr = $this->renderAttr();
		$class = $this->renderClasses();
		$disabled = $this->disabled ? 'disabled' : '';
		return "<input type=\"submit\" id=\"{$this->id}\" name=\"{$this->name}\"  {$attr} {$class} value=\"{$this->value}\"{$disabled} />";
	}

    /**
     * @return string
     */
    public function validate() {
		//doesn't do anything
        return "";
	}

		
}

?>