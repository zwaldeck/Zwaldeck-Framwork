<?php

namespace Zwaldeck\Form\Element;

use Zwaldeck\Exceptoin\NotImplementedYet;

class ColorElement extends AbstractElement {
	
	/**
	 * default color
	 * @var string
	 */
	private $color;
	
	private static $COLORREGEX = "/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\\b/";
	
	/**
	 * @param string $id
	 * @param string $value
	 * @throws \InvalidArgumentException
	 */
	public function __construct($id, $color = "#00000") {
		parent::__construct($id);
		if(!preg_match(self::$COLORREGEX, $color)) {
			throw new \InvalidArgumentException('$color must be a valid Hex color that starts with #');
		}
		
		$this->color = $color;
	}
	
	/**
	 * @return string
	 */
	public function getColor() {
		return $this->color;
	}
	
	/**
	 * @param string $color
	 * @throws \InvalidArgumentException
	 */
	public function setColor($color) {
		if(!preg_match(self::$COLORREGEX, $color)) {
			throw new \InvalidArgumentException('$color must be a valid Hex color that starts with #');
		}
		
		$this->color = $color;
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
		
		return "<input type=\"color\" id=\"{$this->id}\" name=\"{$this->name}\" {$attr} {$class} {$disabled} value=\"{$this->color}\" />";
	}
}

?>