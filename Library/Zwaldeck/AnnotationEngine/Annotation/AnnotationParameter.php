<?php

namespace Zwaldeck\AnnotationEngine\Annotation;


use Zwaldeck\AnnotationEngine\Exceptions\AnnotationException;

/**
 * Class AnnotationParameter
 * @package Zwaldeck\AnnotationEngine\Annotation
 * @author Wout Schoovaerts
 */
class AnnotationParameter {

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $name
     * @param string $value
     * @throws AnnotationException
     */
    public function __construct($name, $value) {
        if(!is_string($name) || trim($name) == "") {
            throw new AnnotationException('$name may not be empty and must be a string');
        }

        if(!is_string($value) || trim($value) == "") {
            throw new AnnotationException('$value may not be empty and must be a string');
        }

        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }


} 