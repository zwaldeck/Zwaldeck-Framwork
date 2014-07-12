<?php

namespace Zwaldeck\Form\Validation;

/**
 * Class NumberValidator
 * @package Zwaldeck\Form\Validation
 * @author wout schoovaerts
 */
class NumberValidator extends AbstractValidator
{
    const ERROR_NR = 703;

    /**
     * @param string $fieldValue
     */
    public function __construct($fieldValue)
    {
        parent::__construct($fieldValue, self::ERROR_NR);
    $this->setErrorMessage("Field must contain a number");
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return is_numeric($this->fieldValue);
    }
} 