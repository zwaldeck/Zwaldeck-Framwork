<?php

namespace Zwaldeck\AnnotationEngine;

use Zwaldeck\AnnotationEngine\Exceptions\AnotationEngingeException;
use Zwaldeck\AnnotationEngine\Method\MethodsAnnotations;

/**
 * Class AnnotationEngine
 * @package Zwaldeck\AnnotationEngine
 */
class AnnotationEngine
{

    private $reflectionClass;
    private $methods;
    private $properties;

    private $methodsAnnotations;

    /**
     * @param $object
     * @throws AnotationEngingeException
     */
    public function __construct($object)
    {
        if (!is_object($object) && !is_string(trim($object))) {
            throw new AnotationEngingeException("The object must be an Object or string!");
        }

        //init
        $this->reflectionClass = new \ReflectionClass($object);
        $this->methods = array();
        $this->properties = array();

        $this->methods = $this->reflectionClass->getMethods();
        $this->properties = $this->reflectionClass->getProperties();

        $this->methodsAnnotations = new MethodsAnnotations($this->methods);


    }

    public function getClassDocblock() {
        return $this->reflectionClass->getDocComment();
    }


} 