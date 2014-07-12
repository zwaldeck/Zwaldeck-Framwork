<?php

namespace Zwaldeck\Form\Validation;


/**
 * Class AbstractValidator
 * @author wout schoovaerts
 * @package Zwaldeck\Form\Validation
 */
abstract class AbstractValidator {

    /**
     * Each validator class had a constant error number starting with 700
     * @var integer
     */
    protected $errornr = 700;

    /**
     * the error message
     * @var string
     */
    protected $errorMessage;

    /**
     * fieldValue;
     * @var mixed
     */
    protected $fieldValue;

    /**
     * @param string $field
     * @param int $errorNr
     */
    protected function __construct($field = "", $errorNr = 700) {
        $this->fieldValue = isset($_POST[$field]) ? $_POST[$field] : "";
        $this->errornr = $errorNr;
    }


    public abstract function isValid();

    /**
     * @param string $message
     */
    protected function setErrorMessage($message) {
       $this->errorMessage = $message;
    }

    /**
     * @return string
     */
    protected function getErrorMessage() {
        return $this->errorMessage;
    }

    /**
     * @return int
     */
    protected function getErrorNR() {
        if(trim($this->errorMessage) == "")
            return 0;
        else
            return $this->errornr;
    }

    /**
     * @return string
     */
    public function getError() {
        return $this->errornr .": ".$this->errorMessage;
    }


}