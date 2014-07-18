<?php

namespace Zwaldeck\Session;

/**
 * The session registry
 * @author Wout Schoovaerts
 */
class SessionRegistry {

    /**
     * @param $key
     * @param $var
     * @throws \InvalidArgumentException
     */
    public static function set($key, $var) {
		if(!is_string($key) || trim($key) == '') {
			throw new \InvalidArgumentException("\$key must be valid");
		}

        if(strtolower($key) == 'current_role') {
            throw new \InvalidArgumentException('$key may not be current_role');
        }

		$var = serialize($var);
		
		$_SESSION[$key] = $var;
	}

    /**
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public static function get($key) {
		if(!is_string($key) || trim($key) == '') {
			throw new \Exception("\$key must be valid");
		}
		if(!array_key_exists($key, $_SESSION)) {
			throw new \Exception("\$key is not found");
		}
		
		return unserialize($_SESSION[$key]);
	}

    /**
     * @param $key
     * @throws \Exception
     */
    public static function delete($key) {
        if(!is_string($key) || trim($key) == '') {
            throw new \Exception("\$key must be valid");
        }
        if(!array_key_exists($key, $_SESSION)) {
            throw new \Exception("\$key is not found");
        }

        unset($_SESSION[$key]);
    }
}
?>
