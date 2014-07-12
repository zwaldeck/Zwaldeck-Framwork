<?php

namespace Zwaldeck\Form\Validation;

/**
 * Class BetweenValidator
 * @package Zwaldeck\Form\Validation
 * @author wout schoovaerts
 */
class BetweenValidator extends AbstractValidator
{

    const ERROR_NR = 705;

    /**
     * @var integer $low
     */
    private $low;

    /**
     * @var integer $high
     */
    private $high;

    /**
     * @param string $fieldValue
     * @param int $low
     * @param $high
     */
    public function __construct($fieldValue, $low, $high)
    {
        parent::__construct($fieldValue, self::ERROR_NR);

        $this->low = abs($low);
        $this->high = abs($high);

        $this->setErrorMessage("Field must be numeric and between {$this->low} and {$this->high}");
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        if(!is_numeric($this->fieldValue)) {
            return false;
        }

        if($this->fieldValue <= $this->low || $this->fieldValue >= $this->high) {
            return false;
        }

        return true;
    }

} 