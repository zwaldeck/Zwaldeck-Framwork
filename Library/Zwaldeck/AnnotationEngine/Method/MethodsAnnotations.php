<?php
/**
 * Created by PhpStorm.
 * User: wout
 * Date: 27.09.14
 * Time: 14:18
 */

namespace Zwaldeck\AnnotationEngine\Method;


class MethodsAnnotations {

    private $methods;

    public function __construct(array $methods) {
        $this->methods = array();

        foreach($methods as $method) {
            $m = new MethodAnnotations($method);
            $this->methods[$m->getName()] = $m;
        }
    }

    //TODO add select functions EX. getMethodByName()
} 