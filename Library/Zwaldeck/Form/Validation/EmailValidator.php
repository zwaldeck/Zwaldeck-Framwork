<?php

namespace Zwaldeck\Form\Validation;

/**
 * Class EmailValidator
 * @package Zwaldeck\Form\Validation
 * @author wout schoovaerts
 */
class EmailValidator extends AbstractValidator
{
    const ERROR_NR = 704;

    /**
     * @param string $fieldValue
     */
    public function __construct($fieldValue)
    {
        parent::__construct($fieldValue, self::ERROR_NR);
        $this->setErrorMessage("Field must be an email adress");
    }

    /**
     * @return mixed
     */
    public function isValid()
    {
        return filter_var($this->fieldValue, FILTER_VALIDATE_EMAIL);
    }

} 