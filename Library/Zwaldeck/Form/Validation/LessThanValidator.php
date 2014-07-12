<?php

namespace Zwaldeck\Form\Validation;

/**
 * Class LessThanValidator
 * @package Zwaldeck\Form\Validation
 * @author wout schoovaerts
 */
class LessThanValidator extends AbstractValidator
{
    const ERROR_NR = 707;

    /**
     * @var integer $number
     */
    private $number;

    /**
     * @param string $fieldValue
     * @param int $number
     */
    public function __construct($fieldValue, $number)
    {
        parent::__construct($fieldValue, self::ERROR_NR);

        $this->number = abs($number);

        $this->setErrorMessage("Field must be numeric and lesser than {$this->number}");
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        if (!is_numeric($this->fieldValue)) {
            return false;
        }

        if ($this->fieldValue >= $this->number) {
            return false;
        }

        return true;
    }

} 