<?php
/**
 * Created by PhpStorm.
 * User: wout
 * Date: 7/12/14
 * Time: 11:19 AM
 */

namespace Zwaldeck\Form\Validation;


class NumberValidator extends AbstractValidator
{
    const ERROR_NR = 703;

    public function __construct($fieldValue)
    {
        parent::__construct($fieldValue, self::ERROR_NR);
    $this->setErrorMessage("Field must contain a number");
    }

    public function isValid()
    {
        return is_numeric($this->fieldValue);
    }
} 