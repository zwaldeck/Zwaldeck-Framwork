<?php

namespace Zwaldeck\Form\Element;

use Zwaldeck\Exception\NotImplementedYet;

class NumberElement extends AbstractElement {
	
	/**
	 * start value slider
	 * default 5
	 * @var integer
	 */
	private $startValue;
	
	/**
	 * the minimum value
	 * default = 0
	 * @var integer
	 */
	private $min;
	
	/**
	 * the maximum value
	 * default = 10
	 * @var integer
	 */
	private $max;
	
	/**
	 * how big the steps are
	 * default = 1
	 * @var integer
	 */
	private $step;
	
	/**
	 * @param string $id
	 * @param number $startValue
	 * @param number $min
	 * @param number $max
	 * @throws \InvalidArgumentException
	 */
	public function __construct($id, $startValue = 5, $min = 0, $max = 10, $step = 1 ) {
		parent::__construct($id);
		
		if(!is_int($startValue)) {
			throw new \InvalidArgumentException('$startValue must be an integer');
		}
		
		if(!is_int($min)) {
			throw new \InvalidArgumentException('$min must be an integer');
		}
		
		if(!is_int($max)) {
			throw new \InvalidArgumentException('$max must be an integer');
		}
		
		if(!is_int($step)) {
			throw new \InvalidArgumentException('$step must be an integer');
		}
		
		if(abs($max) <= abs($min)) {
			throw new \InvalidArgumentException('$max must be bigger than $min');
		}
		
		$this->startValue = abs($startValue);
		$this->min = abs($min);
		$this->max = abs($max);
		$this->step = abs($step);
	}
	
	
	/**
	 * @return integer
	 */
	public function getStartValue() {
		return $this->startValue;
	}

	/**
	 * @param number $startValue
	 * @throws \InvalidArgumentException
	 */
	public function setStartValue($startValue) {
		if(!is_int($startValue)) {
			throw new \InvalidArgumentException('$startValue must be an integer');
		}
		
		$this->startValue = $startValue;
	}

	/**
	 * @return integer
	 */
	public function getMin() {
		return $this->min;
	}

	/**
	 * @param number $min
	 * @throws \InvalidArgumentException
	 */
	public function setMin($min) {
		if(!is_int($min)) {
			throw new \InvalidArgumentException('$min must be an integer');
		}
		
		$this->min = abs($min);
		$this->checkMinMax();
	}

	/**
	 * @return integer
	 */
	public function getMax() {
		return $this->max;
	}

	/**
	 * @param number $max
	 * @throws \InvalidArgumentException
	 */
	public function setMax($max) {
		if(!is_int($max)) {
			throw new \InvalidArgumentException('$max must be an integer');
		}
		
		$this->max = abs($max);
		$this->checkMinMax();
	}
	
	/**
	 * @return integer
	 */
	public function getStep() {
		return $this->step;
	}
	
	/**
	 * @param number $step
	 * @throws \InvalidArgumentException
	 */
	public function setStep($step) {
		if(!is_int($step)) {
			throw new \InvalidArgumentException('$step must be an integer');
		}
	
		$this->step = abs($step);
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
		
		return "<input type=\"number\" id=\"{$this->id}\" name=\"{$this->name}\" step=\"{$this->step}\" {$attr} {$class} {$disabled} {$required} min=\"{$this->min}\" max=\"{$this->max}\" />";
	}
	
	/**
	 * @throws \InvalidArgumentException
	 */
	private function checkMinMax() {
		if(abs($this->max) >= abs($this->min)) {
			throw new \InvalidArgumentException('$max must be bigger than $min');
		}
	}
}

?>