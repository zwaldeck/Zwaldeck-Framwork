<?php

namespace Zwaldeck\Exception;

/**
 * Class ElementNotFoundException
 * @package Zwaldeck\Exception
 * @author wout schoovaerts
 */
class ElementNotFoundException extends \Exception {

    /**
     *
     * @param string $message
     * @param number $code
     * @param \Exception $previous
     */
    public function __construct($message, $code = 0,\Exception $previous = null) {
        parent::__construct ( $message, $code, $previous );
    }
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}