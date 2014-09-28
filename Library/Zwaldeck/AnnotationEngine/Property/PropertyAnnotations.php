<?php

namespace Zwaldeck\AnnotationEngine\Property;

use Zwaldeck\AnnotationEngine\Annotation\Annotation;
use Zwaldeck\AnnotationEngine\AnnotationAble;

/**
 * Class PropertyAnnotations
 * @package Zwaldeck\AnnotationEngine\Property
 * @author Wout Schoovaerts
 */
class PropertyAnnotations implements AnnotationAble {

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $docComment;

    /**
     * @var array
     */
    private $annotations;

    /**
     * @param \ReflectionProperty $property
     * @throws PropertyAnnotationsException
     */
    public function __construct(\ReflectionProperty $property) {
        if($property == null) {
            throw new PropertyAnnotationsException("Not a valid property!");
        }

        $this->name = $property->getName();
        $this->docComment = $property->getDocComment();
        $this->annotations = array();

        $this->parse();
    }

    /**
     * @return array
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

    /**
     * @param string $name
     * @return Annotation
     * @throws MethodAnnotationsException
     */
    public function getAnnotationByName($name)
    {
        if(!$this->hasAnnotationByName($name)) {
            throw new MethodAnnotationsException("Could not find annotation with the name \"{$name}\"");
        }

        return $this->annotations[$name];
    }

    /**
     * @return boolean
     */
    public function hasAnnotations()
    {
        return count($this->annotations) > 0;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function hasAnnotationByName($name)
    {
        if($this->hasAnnotations()) {
            return array_key_exists($name, $this->annotations);
        }

        return false;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    private function parse() {
        $docBlock = trim(preg_replace('/\s+/', ' ', $this->docComment));
        $docBlock = trim(str_replace('*', '', $docBlock));
        $docBlock = trim(str_replace('/', '', $docBlock));

        $strings = explode('@', $docBlock);
        $rawAnnotations = array();

        //cleanup
        foreach($strings as $s) {
            if(trim($s) != "") {
                $rawAnnotations[] = trim($s);
            }
        }

        $annotation = null;
        foreach($rawAnnotations as $raw) {
            $annotation = new Annotation($raw);
            $name = $annotation->getName();
            $this->annotations[$name] = $annotation;
        }
    }
}