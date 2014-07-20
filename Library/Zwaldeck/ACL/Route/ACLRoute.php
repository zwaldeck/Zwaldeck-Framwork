<?php

namespace Zwaldeck\ACL;

/**
 * Class ACLRoute
 * @package Zwaldeck\ACL
 * @author Wout Schoovaerts
 */
class ACLRoute {

    private $uri;

    /**
     * has it a wildcard
     * @var bool
     */
    private $wildcard = false;

    /**
     * @param $route
     * @throws \InvalidArgumentException
     */
    public function __construct($route) {
        if(!is_string($route) || trim($route) == "") {
            throw new \InvalidArgumentException('$route must be a string and may not be empty');
        }

        $this->uri = $route;
    }

} 