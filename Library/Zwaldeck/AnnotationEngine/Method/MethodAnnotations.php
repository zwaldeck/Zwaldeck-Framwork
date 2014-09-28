<?php
/**
 * Created by PhpStorm.
 * User: wout
 * Date: 27.09.14
 * Time: 14:18
 */

namespace Zwaldeck\AnnotationEngine\Method;


use Zwaldeck\AnnotationEngine\Annotation\Annotation;
use Zwaldeck\AnnotationEngine\AnnotationAble;
use Zwaldeck\AnnotationEngine\Exceptions\MethodAnnotationsException;

/**
 * Class MethodAnnotations
 * @package Zwaldeck\AnnotationEngine\Method
 * @author Wout Schoovaerts
 */
class MethodAnnotations implements AnnotationAble {

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
     * @param \ReflectionMethod $method
     * @throws MethodAnnotationsException
     */
    public function __construct(\ReflectionMethod $method) {
        if($method == null) {
            throw new MethodAnnotationsException("Not a valid method!");
        }

        $this->name = $method->getName();
        $this->docComment = $method->getDocComment();
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