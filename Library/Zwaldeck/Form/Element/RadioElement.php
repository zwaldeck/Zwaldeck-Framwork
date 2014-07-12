<?php
namespace Zwaldeck\Form\Element;

use Zwaldeck\Form\Label;

/**
 * Class RadioElement
 * @package Zwaldeck\Form\Element
 * @author wout schoovaerts
 */
class RadioElement extends AbstractElement {
	
	/**
	 * the autofocus attribute
	 * @var boolean
	 */
	private $autofocus;
	
	/**
	 * checked attribute
	 * @var boolean
	 */
	private $checked;
	
	/**
	 * 
	 * @param string $id
	 * @param string $name
	 * @param string $text
	 * @param boolean $checked
	 * @param boolean $required
	 * @param boolean $disabled
	 * @param boolean $autfocus
	 * @throws \InvalidArgumentException
	 */
	public function __construct($id, $name, $text = "", $checked = false, $required = false, $disabled = false, $autfocus = false) {
		parent::__construct($id);
		if(!is_string($name) || trim($name) == "") {
			throw new \InvalidArgumentException('$name must be a valid string and may not be empty');
		}
		
		if(!is_string($text)) {
			throw new \InvalidArgumentException('$text must be a valid string');
		}
		
		if(!is_bool($checked)) {
			throw new \InvalidArgumentException('$checked must be true or false');
		}
		
		if(!is_bool($required)) {
			throw new \InvalidArgumentException('$required must be true or false');
		}
		
		if(!is_bool($disabled)) {
			throw new \InvalidArgumentException('$disabled must be true or false');
		}
		
		if(!is_bool($autfocus)) {
			throw new \InvalidArgumentException('$autfocus must be true or false');
		}
		
		
		$this->name = $name;
		$this->label = new Label('label_'.$id, $id, $text);
		$this->checked = $checked;
		$this->required = $required;
		$this->disabled = $disabled;
		$this->autofocus = $autfocus;
	}

    /**
     * @return bool
     */
    public function getAutofocus() {
		return $this->autofocus;
	}

    /**
     * @param $autofocus
     * @throws \InvalidArgumentException
     */
    public function setAutofocus($autofocus) {
		if(!is_bool($autofocus)) {
			throw new \InvalidArgumentException('$autofocus must be true or false');
		}
		
		$this->autofocus = $autofocus;
	}

    /**
     * @return bool
     */
    public function getChecked() {
		return $this->checked;
	}

    /**
     * @param $checked
     * @throws \InvalidArgumentException
     */
    public function setChecked($checked) {
		if(!is_bool($checked)) {
			throw new \InvalidArgumentException('$checked must be true or false');
		}
		
		$this->checked = $checked;
	}

    /**
     * render with label
     * @return string
     */
    public function render() {
		$attr = $this->renderAttr();
		$class = $this->renderClasses();
		$disabled = $this->disabled ? 'disabled' : '';
		$required = $this->required ? 'required' : '';
		$auto = $this->autofocus ? 'autofocus' : '';
		$checked = $this->checked ? 'checked' : '';
		
		return "<input type=\"radio\" id=\"{$this->id}\" name=\"{$this->name}\" {$class} {$attr} {$disabled} {$required} {$auto} {$checked} value=\"{$this->value}\" />";
	}
	
}