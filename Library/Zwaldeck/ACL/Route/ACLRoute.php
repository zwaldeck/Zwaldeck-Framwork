<?php

namespace Zwaldeck\ACL\Route;

use Zwaldeck\ACL\Role\ACLRole;
use Zwaldeck\Util\Utils;

/**
 * Class ACLRoute
 * @package Zwaldeck\ACL
 * @author Wout Schoovaerts
 */
class ACLRoute {

    /**
     * @var string
     */
    private $uri;

    /**
     * @var ACLRole
     */
    private $role;

    /**
     * has it a wildcard
     * @var bool
     */
    private $wildcard = false;

    /**
     * @param string $uri
     * @param ACLRole $role
     * @throws \InvalidArgumentException
     */
    public function __construct($uri, ACLRole $role) {
        if(!is_string($uri) || trim($uri) == "") {
            throw new \InvalidArgumentException('$route must be a string and may not be empty');
        }

        $this->uri = $uri;
        $this->role = $role;

        if(Utils::endsWith($this->uri, '*')) {
            $this->wildcard = true;
        }
    }

    /**
     * @return bool
     */
    public function hasWildCard() {
        return $this->wildcard;
    }

    /**
     * @return string
     */
    public function getURI() {
        return $this->uri;
    }

    /**
     * @return Role
     */
    public function getRole() {
        return $this->role;
    }
}