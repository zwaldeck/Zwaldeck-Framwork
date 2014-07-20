<?php

namespace Zwaldeck\ACL;

use Zwaldeck\ACL\Role\ACLRole;
use Zwaldeck\ACL\Role\ACLRoles;
use Zwaldeck\ACL\Route\ACLRoutes;
use Zwaldeck\Db\Adapter\AbstractAdapter;
use Zwaldeck\Db\Helpers\Select;
use Zwaldeck\Exception\NotImplementedYet;

/**
 * Class ACL
 * @package Zwaldeck\ACL
 * @author Wout Schoovaerts
 */
class ACL {

    /** @var \Zwaldeck\ACL\Role\ACLRoles  */
    private $roles;


    public function __construct() {
        $this->roles = ACLRoles::getInstance();
    }

    /**
     * @param AbstractAdapter $db
     * @param integer $userid
     * @return Role\ACLRole
     * @throws \InvalidArgumentException
     */
    public function getRoleFromUser(AbstractAdapter $db, $userid) {
        if(!is_numeric($userid)) {
            throw new \InvalidArgumentException('$userid must be an integer');
        }

        $select = $db->select()
            ->from(array('u_r' => 'users_role'), array('role'))
            ->where('user_id =', $userid, Select::SQL_FIRST);

        $role = $db->fetchRow($select)[0]['role'];

        return $this->roles->getRole($role);
    }

    /**
     * @param AbstractAdapter $db
     * @param string $role
     * @return array
     * @throws \InvalidArgumentException
     */
    public function getUsersFromRole(AbstractAdapter $db, $role) {
        if(!is_string($role) || trim($role) == "") {
            throw new \InvalidArgumentException('$role must be a valid string and may not be empty');
        }

        $select = $db->select()
            ->from(array('u_r' => 'users_role'), array('user_id'))
            ->where('role =', $role, Select::SQL_FIRST);

        $users = $db->fetchAssoc($select);
        $return = array();

        foreach ($users as $user) {
            $return[] = $user['user_id'];
        }

        return $return;
    }

    /**
     * @param string $uri
     * @throws \InvalidArgumentException
     * @return ACLRole
     */
    public function getRoleFromUri($uri) {
        $routes = ACLRoutes::getInstance()->getRoutes();
        foreach($routes as $route) {
            $ACLRouteURI = $route->getURI();

            if(strtolower($ACLRouteURI) == strtolower($uri)) {
                return $route->getRole();
            }
        }

        throw new \InvalidArgumentException("No role found for route {$uri}");
    }

    /**
     * @param $role_name
     * @return array
     */
    public function getURIsFromRole($role_name) {
        $routes = ACLRoutes::getInstance()->getRoutes();

        $matching = array();

        foreach($routes as $route) {
            $ACLRole = ACLRoles::getInstance()->getRole($role_name);
            if($route->getRole()->getName() == $ACLRole->getName()) {
                $matching[] = $route->getURI();
            }
        }

        return $matching;
    }

    /**
     * @param $route_name
     * @return ACLRole|null
     */
    public function getRoleFromRouteName($route_name) {
        if(array_key_exists($route_name, ACLRoutes::getInstance()->getRoutes()))  {
            return ACLRoutes::getInstance()->getRoutes()[$route_name]->getRole();
        }

        return null;
    }

    /**
     * @param $route_name
     * @return string
     */
    public function getURIFromRouterName($route_name) {
        if(array_key_exists($route_name, ACLRoutes::getInstance()->getRoutes()))  {
            return ACLRoutes::getInstance()->getRoutes()[$route_name]->getURI();
        }

        return "";
    }
}