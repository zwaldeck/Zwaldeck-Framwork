<?php
/**
 * Created by PhpStorm.
 * User: wout
 * Date: 6/30/14
 * Time: 6:28 AM
 */

namespace Zwaldeck\Form\Validation;


class RequiredValidator extends AbstractValidator{

    const ERROR_NR = 701;

    public function __construct($fieldValue = "") {
        parent::__construct($fieldValue,self::ERROR_NR);

        $this->errorMessage = "This field can not be empty";
    }

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