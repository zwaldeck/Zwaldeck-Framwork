<?php

namespace Zwaldeck\ACL\Role;

/**
 * Class ACLRole
 * @package Zwaldeck\ACL\ACLRole
 * @author Wout Schoovaerts
 */
class ACLRole {

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     * @throws \InvalidArgumentException
     */
    public function __construct($name) {

        if(!is_string($name) || trim($name) == "") {
            throw new \InvalidArgumentException('$name must be a valid string and may not be empty');
        }
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }
} 