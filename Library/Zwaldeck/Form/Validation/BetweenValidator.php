<?php
/**
 * Created by PhpStorm.
 * User: wout
 * Date: 7/12/14
 * Time: 2:28 PM
 */

namespace Zwaldeck\Form\Validation;


class BetweenValidator extends AbstractValidator
{
    const ERROR_NR = 705;

    /**
     * @var integer $low
     */
    private $low;

    /**
     * @var integer $high
     */
    private $high;

    public function __construct($fieldValue, $low, $high)
    {
        parent::__construct($fieldValue, self::ERROR_NR);

        $this->low = abs($low);
        $this->high = abs($high);

        $this->setErrorMessage("Field must be numeric and between {$this->low} and {$this->high}");
    }

    public function isValid()
    {
        if(!is_numeric($this->fieldValue)) {
            return false;
        }

        if($this->fieldValue <= $this->low || $this->fieldValue >= $this->high) {
            return false;
        }

        return true;
    }

} 