<?php

namespace Zwaldeck\ACL;
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
    private $instance;

    /** @var array */
    private $routes;

    /**
     * singleton
     */
    private function __construct() {
        $routes = Registry::get('ACLConfig')['routes'];

        foreach($routes as $route) {

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

}