<?php

namespace Zwaldeck\Form\Validation;


class LessThanValidator extends AbstractValidator
{
    const ERROR_NR = 707;

    /**
     * @var integer $number
     */
    private $number;


    public function __construct($fieldValue, $number)
    {
        parent::__construct($fieldValue, self::ERROR_NR);

        $this->number = abs($number);

        $this->setErrorMessage("Field must be numeric and lesser than {$this->number}");
    }

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