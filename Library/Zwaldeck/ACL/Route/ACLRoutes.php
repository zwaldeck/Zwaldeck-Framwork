<?php

namespace Zwaldeck\ACL\Route;

use Zwaldeck\ACL\Role\ACLRoles;
use Zwaldeck\Registry\Registry;
use Zwaldeck\Util\Interfaces\SingletonInterface;


/**
 * Class ACLRoutes
 * @package Zwaldeck\ACL
 * @author Wout Schoovaerts
 *
 * Singleton
 */
class ACLRoutes implements SingletonInterface {


    /** @var ACLRoutes */
    private static $instance = null;

    /** @var array */
    private $routes;

    /**
     * singleton
     */
    private function __construct() {
        $routes = Registry::get('ACLConfig')['routes'];

        foreach($routes as $name => $route) {
            $this->routes[$name] = new ACLRoute($route['uri'], ACLRoles::getInstance()->getRole($route['role']));
        }
    }

    /**
     * @return ACLRoutes
     */
    public static function getInstance()
    {
        if(self::$instance == null) {

            self::$instance = new ACLRoutes();
        }

        return self::$instance;
    }

    /**
     * @param $name
     * @return ACLRoute
     * @throws \InvalidArgumentException
     */
    public function getRoute($name) {
        if(!is_string($name) || trim($name) == "") {
            throw new \InvalidArgumentException('$name must be a valid string and may not be empty');
        }

        if(!array_key_exists($name, $this->routes)) {
            throw new \InvalidArgumentException("Could not find route {$name}");
        }

        return $this->routes[$name];
    }

    /**
     * @return array
     */
    public function getRoutes() {
        return $this->routes;
    }

}