<?php

namespace Zwaldeck\Form\Validation;

/**
 * Class RequiredValidator
 * @package Zwaldeck\Form\Validation
 * @author wout schoovaerts
 */
class RequiredValidator extends AbstractValidator{

    const ERROR_NR = 701;

    /**
     * @param string $fieldValue
     */
    public function __construct($fieldValue = "") {
        parent::__construct($fieldValue,self::ERROR_NR);

        $this->errorMessage = "This field can not be empty";
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        if(trim($this->fieldValue) == "") {
            return false;
        }

        if($this->fieldValue == null)
            return false;

        return true;
    }
}