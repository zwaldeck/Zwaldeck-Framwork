<?php

namespace Zwaldeck\AnnotationEngine;
use Zwaldeck\AnnotationEngine\Annotation\Annotation;

/**
 * Interface AnnotationAble
 * @package Zwaldeck\AnnotationEngine
 * @author Wout Schoovaerts
 */
interface AnnotationAble {

    /**
     * @return array
     */
    public function getAnnotations();

    /**
     * @param string $name
     * @return Annotation
     */
    public function getAnnotationByName($name);

    /**
     * @return boolean
     */
    public function hasAnnotations();

    /**
     * @param string $name
     * @return boolean
     */
    public function hasAnnotationByName($name);
} 