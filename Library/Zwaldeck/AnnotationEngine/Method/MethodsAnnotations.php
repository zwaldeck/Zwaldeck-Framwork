<?php

namespace Zwaldeck\AnnotationEngine\Method;


use Zwaldeck\AnnotationEngine\Exceptions\MethodAnnotationsException;

/**
 * Class MethodsAnnotations
 * @package Zwaldeck\AnnotationEngine\Method
 * @author Wout Schoovaerts
 */
class MethodsAnnotations {

    /**
     * @var array
     */
    private $methods;

    /**
     * @param array $methods
     */
    public function __construct(array $methods) {
        $this->methods = array();

        foreach($methods as $method) {
            $m = new MethodAnnotations($method);
            $this->methods[$m->getName()] = $m;
        }
    }

    /**
     * @return array
     */
    public function getMethods() {
        return $this->methods;
    }

    /**
     * @param $name
     * @return mixed
     * @throws MethodAnnotationsException
     */
    public function getMethodByName($name) {
        if(!is_string($name) || trim($name) == "") {
            throw new MethodAnnotationsException('$name must be a valid string and may not be empty');
        }

        if(!$this->hasMethodByName($name)) {
            throw new MethodAnnotationsException('Could not find annotations for method: "'. $name . '"');
        }

        return $this->methods[$name];
    }

    /**
     * @return bool
     */
    public function hasMethods() {
        return count($this->methods) > 0;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasMethodByName($name) {
        if($this->hasMethods()) {
            return array_key_exists($name, $this->methods);
        }

        return false;
    }
} 