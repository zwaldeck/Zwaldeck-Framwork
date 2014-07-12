<?php
/**
 * Created by PhpStorm.
 * User: wout
 * Date: 7/12/14
 * Time: 11:46 AM
 */

namespace Zwaldeck\Form\Validation;


class EmailValidator extends AbstractValidator
{
    const ERROR_NR = 704;

    public function __construct($fieldValue)
    {
        parent::__construct($fieldValue, self::ERROR_NR);
        $this->setErrorMessage("Field must be an email adress");
    }

    public function isValid()
    {
        return filter_var($this->fieldValue, FILTER_VALIDATE_EMAIL);
    }

} 