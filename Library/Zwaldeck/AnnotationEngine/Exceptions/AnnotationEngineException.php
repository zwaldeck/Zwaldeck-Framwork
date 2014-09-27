<?php

namespace Zwaldeck\AnnotationEngine\Exceptions;
/**
 * Class AnotationEngingeException
 * @author Wout Schoovaerts
 * @package Zwaldeck\AnnotationEngine\Exceptions
 */
class AnnotationEngineException extends \Exception {

    /**
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
} 