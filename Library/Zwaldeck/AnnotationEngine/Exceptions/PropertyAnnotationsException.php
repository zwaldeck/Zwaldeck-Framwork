<?php

namespace Zwaldeck\AnnotationEngine\Exceptions;

/**
 * Class MethodAnnotationsException
 * @package Zwaldeck\AnnotationEngine\Exceptions
 */
class PropertyAnnotationsException extends AnnotationEngineException{

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