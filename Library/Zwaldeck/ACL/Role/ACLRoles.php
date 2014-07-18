<?php

namespace Zwaldeck\ACL\Role;

use Zwaldeck\Registry\Registry;
use Zwaldeck\Util\Interfaces\SingletonInterface;

/**
 * Class ACLRoles
 * @package Zwaldeck\ACL\ACLRole
 * @author Wout Schoovaerts
 *
 * Singleton
 */
class ACLRoles implements SingletonInterface {

    /** @var ACLRoles */
    private static $instance = null;

    /** @var array */
    private $roles;

    private function __construct() {
        $config = Registry::get('ACLConfig');

        foreach($config['roles'] as $role) {
            $this->roles[$role] = new ACLRole($role);
        }
    }

    /**
     * @return array
     */
    public function getRoles() {
        return $this->roles();
    }

    /**
     * @param string $name
     * @return ACLRole
     * @throws \InvalidArgumentException
     */
    public function getRole($name) {
        if(!is_string($name) || trim($name) == "") {
            throw new \InvalidArgumentException('$name must be a valid string and may not be empty');
        }

        if(!array_key_exists($name, $this->roles)) {
            throw new \InvalidArgumentException('Could not find the name: "'.$name.'"');
        }

        return $this->roles[$name];
    }

    /**
     * @return ACLRoles
     */
    public static function getInstance() {
        if(self::$instance == null) {
            self::$instance = new ACLRoles();
        }

        return self::$instance;
    }
} 