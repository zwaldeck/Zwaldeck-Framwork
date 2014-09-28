<?php

namespace Zwaldeck\AnnotationEngine;

use Zwaldeck\AnnotationEngine\Exceptions\AnotationEngingeException;
use Zwaldeck\AnnotationEngine\Method\MethodsAnnotations;
use Zwaldeck\AnnotationEngine\Property\PropertiesAnnotations;

/**
 * Class AnnotationEngine
 * @package Zwaldeck\AnnotationEngine
 * @author Wout Schoovaerts
 */
class AnnotationEngine
{
    /**
     * @var \ReflectionClass
     */
    private $reflectionClass;
    /**
     * @var \ReflectionMethod[]
     */
    private $methods;
    /**
     * @var \ReflectionProperty[]
     */
    private $properties;

    /**
     * @var MethodsAnnotations
     */
    private $methodsAnnotations;
    /**
     * @var PropertiesAnnotations
     */
    private $propertiesAnnotations;

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
        $this->propertiesAnnotations = new PropertiesAnnotations($this->properties);
    }

    /**
     * @return string
     */
    public function getClassDocblock() {
        return $this->reflectionClass->getDocComment();
    }

    /**
     * @return PropertiesAnnotations
     */
    public function getProperties() {
        return $this->propertiesAnnotations;
    }

    /**
     * @return MethodsAnnotations
     */
    public function getMethods() {
        return $this->methodsAnnotations;
    }


} 