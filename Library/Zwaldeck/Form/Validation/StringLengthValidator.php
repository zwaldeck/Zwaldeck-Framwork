<?php
/**
 * Created by PhpStorm.
 * User: wout
 * Date: 7/1/14
 * Time: 1:14 PM
 */

namespace Zwaldeck\Form\Validation;

/**
 * Class StringLengthValidator
 * @author Wout Schoovaerts
 * @package Zwaldeck\Form\Validation
 */
class StringLengthValidator extends AbstractValidator
{
    const ERROR_NR = 702;
    const NO_MAX = 0;

    /**
     * @var integer
     */
    private $min;

    /**
     * 0 means no max
     * @var integer
     */
    private $max;

    public function __construct($fieldValue, $min = 0, $max = 0)
    {
        parent::__construct($fieldValue, ERROR_NR);
        $this->max = abs($max);
        $this->min = abs($min);

        if($this->max > 0)
            $this->errorMessage = "Field must be longer than {$this->min} and smaller than {$this->max}";
        else
            $this->errorMessage = "Field must be longer than {$this->min}";
    }

    public function isValid()
    {
        if ($this->max > 0) {
            if (strlen(trim($this->fieldValue)) >= $this->min && strlen(trim($this->fieldValue)) <= $this->max) {
                return true;
            }
        }
        else if(strlen(trim($this->fieldValue)) >= $this->min ) {
           return true;
        }

        return false;
    }


} 