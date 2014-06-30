<?php

namespace Zwaldeck\Form\Element\Text;

use Zwaldeck\Exceptoin\NotImplementedYet;

class TextAreaElement extends AbstractTextElement {
	
	/**
	 * default = 0 means it does not have rows attribute
	 *
	 * @var integer
	 */
	private $rows;
	
	/**
	 * default = 0 means it does not have cols attribute
	 * 
	 * @var integer
	 */
	private $cols;
	
	public function __construct($id) {
		parent::__construct($id);
		
		$this->rows = 0;
		$this->cols = 0;
	}
	
	/**
	 * get rows
	 * @return number
	 */
	public function getRows() {
		return $this->rows;
	}
	
	/**
	 * get cols
	 * @return number
	 */
	public function getCols() {
		return $this->cols;
	}
	
	/**
	 * set the rows attribute
	 * @param integer $rows
	 * @throws \InvalidArgumentException
	 */
	public function setRows($rows) {
		if(!is_int($rows)) {
			throw new \InvalidArgumentException('$rows must be an integer');
		}
		
		$this->rows = $rows;
	}
	
	/**
	 * set the cols attribute
	 * @param integer $cols
	 * @throws \InvalidArgumentException
	 */
	public function setCols($cols) {
		if(!is_int($cols)) {
			throw new \InvalidArgumentException('$cols must be an integer');
		}
	
		$this->cols = $cols;
	}
	
	/**
	 * @throws NotImplementedYet
	 */
	public function validate() {
		throw new NotImplementedYet();
	}
	public function render() {
		$rows = $this->rows == 0 ? '' : 'rows="'.$this->rows.'"';
		$cols = $this->cols == 0 ? '' : 'cols="'.$this->cols.'"';
		$attr = $this->renderAttr();
		$class = $this->renderClasses();
		$required = $this->required ? 'required' : '';
		$disabled = $this->disabled ? 'disabled' : '';
		$readonly = $this->readonly ? 'readonly' : '';
		
		
		return "<textarea id=\"{$this->id}\" {$attr} name=\"{$this->name}\" {$required} {$class} {$disabled} {$readonly} maxlength=\"{$this->maxlenght}\" placeholder=\"{$this->placeholder}\" {$rows} {$cols}>{$this->value}</textarea>";
		
	}
}

?>