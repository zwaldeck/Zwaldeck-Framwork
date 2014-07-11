<?php

namespace Zwaldeck\Form\Element\Text;

use Zwaldeck\Exception\NotImplementedYet;
use Zwaldeck\Util\Utils;

class TextElement extends AbstractTextElement {
	
	/**
	 * the type
	 * 
	 * @var string
	 */
	private $type;
	
	/**
	 * The size of the element
	 * 
	 * default = 0 --> attr not rendered
	 * @var integer
	 */
	private $size;

	/**
	 * all the supported types for this element
	 * @var array
	 */
	public static $TYPES = array(
		'text',
		'password',
		'url',
		'email',
		'search',
	);
	
	/**
	 * @param string $id
	 * @param string $type
	 */
	public function __construct($id, $type = 'text') {
		parent::__construct($id);

		if(!in_array(strtolower($type), self::$TYPES)) {
			throw new \InvalidArgumentException('$Type must be a valid type. Check TextElement::$TYPES for all the types');
		}
		
		$this->type = $type;
		$this->size = 0;
	}
	
	
	
	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @return the $size
	 */
	public function getSize() {
		return $this->size;
	}

	/**
	 * @param string $type
	 * @throws \InvalidArgumentException
	 */
	public function setType($type) {
		if(!is_string($type) || trim($type) == "") {
			throw new \InvalidArgumentException('$type must be a string and not empty');
		}
		
		$this->type = $type;
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


	public function validate() {
        Utils::vardump($this->validators);
		foreach($this->validators as $validator) {
            if($validator->isValid()) {
                return $validator->getError();
            }
        }

        return true;
	}
	
	public function render() {
		$size = $this->size == 0 ? '' : 'size="'.$this->size.'"';
		$type = "type=\"{$this->type}\"";//
		$attr = $this->renderAttr();//
		$class = $this->renderClasses();//
		$required = $this->required ? 'required' : '';//
		$disabled = $this->disabled ? 'disabled' : '';//
		$readonly = $this->readonly ? 'readonly' : '';//
        $maxLength = $this->maxlenght == 0 ? "" : "maxlength=\"{$this->maxlenght}\"";
		
		return "<input {$type} id=\"{$this->id}\" {$attr} name=\"{$this->name}\" {$required} {$class} {$disabled} value=\"{$this->value}\" {$readonly} {$maxLength} placeholder=\"{$this->placeholder}\" {$size} />";
	}
}

?>