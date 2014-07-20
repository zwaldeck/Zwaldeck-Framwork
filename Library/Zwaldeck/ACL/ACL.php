<?php

namespace Zwaldeck\ACL;

use Zwaldeck\ACL\Role\ACLRoles;
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

    public function getRoleFromUri($uri) {

    }

} 