<?php
/**
 * Created by PhpStorm.
 * User: wout
 * Date: 27.09.14
 * Time: 14:32
 */

namespace Zwaldeck\AnnotationEngine\Annotation;


use Zwaldeck\AnnotationEngine\Exceptions\AnnotationException;

class Annotation {

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $params;

    /**
     * @param string $singleAnnotation
     * @throws AnnotationException
     */
    public function __construct($singleAnnotation) {
        if(!is_string($singleAnnotation) || trim($singleAnnotation) == "") {
            throw new AnnotationException('$name may not be empty and must be a string');
        }

        if(strpos($singleAnnotation, '(') !== FALSE && strpos($singleAnnotation, ')') !== FALSE ) {
            $strings = explode('(', $singleAnnotation);
            $this->name = $strings[0];
            $params = explode(',', rtrim($strings[1], ')'));

            foreach($params as $param) {
                $param = trim($param);
                $split = explode('=', $param);
                $paramObj = new AnnotationParameter($split[0], $split[1]);
                $this->params[$paramObj->getName()] = $paramObj;
            }
        }
        else {
            if(strpos($singleAnnotation, '(') !== FALSE) {
                throw new AnnotationException('You are missing a closing ")"');
            }
            else if(strpos($singleAnnotation, ')') !== FALSE) {
                throw new AnnotationException('You are missing an opening "("');
            }

            $this->name = trim($singleAnnotation);
            $this->params = null;
        }
    }

    public function getName(){
        return rand(0,9999999);
    }
} 