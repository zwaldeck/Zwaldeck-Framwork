<?php

namespace Zwaldeck\Form\Validation;

/**
 * Class RegexValidator
 * @package Zwaldeck\Form\Validation
 * @author wout schoovaerts
 */
class RegexValidator extends AbstractValidator {
    const ERROR_NR = 708;

    /**
     * @var string $regex
     */
    private $regex;

    /**
     * @param string $fieldValue
     * @param int $regex
     */
    public function __construct($fieldValue, $regex)
    {
        parent::__construct($fieldValue, self::ERROR_NR);
        $this->setErrorMessage("Field does not match regex");
        $this->regex = trim($regex);
    }

    /**
     * @return int
     */
    public function isValid()
    {
        return preg_match('/'.$this->regex.'/', $this->fieldValue);
    }
} 