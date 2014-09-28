<?php
namespace Zwaldeck\AnnotationEngine\Property;

/**
 * Class PropertiesAnnotations
 * @package Zwaldeck\AnnotationEngine\Property
 * @author Wout Schoovaerts
 */
class PropertiesAnnotations {

    /**
     * @var array
     */
    private $properties;

    /**
     * @param array $properties
     */
    public function __construct(array $properties) {
        $this->properties = array();

        foreach($properties as $property) {
            $p = new PropertyAnnotations($property);
            $this->properties[$p->getName()] = $p;
        }
    }

    /**
     * @return array
     */
    public function getProperties() {
        return $this->properties;
    }

    /**
     * @param $name
     * @return mixed
     * @throws MethodAnnotationsException
     */
    public function getPropertyByName($name) {
        if(!is_string($name) || trim($name) == "") {
            throw new MethodAnnotationsException('$name must be a valid string and may not be empty');
        }

        if(!$this->hasPropertyByName($name)) {
            throw new MethodAnnotationsException('Could not find annotations for method: "'. $name . '"');
        }

        return $this->methods[$name];
    }

    /**
     * @return bool
     */
    public function hasProperties() {
        return count($this->properties) > 0;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasPropertyByName($name) {
        if($this->hasProperties()) {
            return array_key_exists($name, $this->properties);
        }

        return false;
    }
} 