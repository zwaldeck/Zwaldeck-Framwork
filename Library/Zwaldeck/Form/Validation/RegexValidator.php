<?php
/**
 * Created by PhpStorm.
 * User: wout
 * Date: 7/12/14
 * Time: 2:52 PM
 */

namespace Zwaldeck\Form\Validation;


class RegexValidator extends AbstractValidator {
    const ERROR_NR = 708;

    /**
     * @var string $regex
     */
    private $regex;

    public function __construct($fieldValue, $regex)
    {
        parent::__construct($fieldValue, self::ERROR_NR);
        $this->setErrorMessage("Field does not match regex");
        $this->regex = trim($regex);
    }

    public function isValid()
    {
        return preg_match('/'.$this->regex.'/', $this->fieldValue);
    }
} 