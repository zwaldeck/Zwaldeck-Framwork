<?php
/**
 * Created by PhpStorm.
 * User: wout
 * Date: 7/12/14
 * Time: 2:41 PM
 */

namespace Zwaldeck\Form\Validation;


class GreatherThanValidator extends AbstractValidator
{
    const ERROR_NR = 706;

    /**
     * @var integer $number
     */
    private $number;


    public function __construct($fieldValue, $number)
    {
        parent::__construct($fieldValue, self::ERROR_NR);

        $this->number= abs($number);

        $this->setErrorMessage("Field must be numeric and greather than {$this->number}");
    }

    public function isValid()
    {
        if(!is_numeric($this->fieldValue)) {
            return false;
        }

        if($this->fieldValue <= $this->number) {
            return false;
        }

        return true;
    }

} 