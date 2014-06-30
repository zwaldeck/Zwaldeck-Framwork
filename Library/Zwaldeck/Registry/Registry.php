<?php

namespace Zwaldeck\Registry;

/**
 * The Registry of the framework
 * 
 * The whole class is static
 * @author Wout Schoovaerts
 *
 */
class Registry {
	/**
	 * All the values of the Registry
	 * @var array
	 */
	private static $values = array();
	
	/**
	 * sets for the given key a value
	 * @param string $key
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 */
	public static function put($key, $value) {
		if(!is_string($key) || trim($key) == '')
			throw new \InvalidArgumentException('$key must be a valid string');
		
		self::$values[$key] = $value;
	}
	
	/**
	 * alias for put
	 * @param string $key
	 * @param mixed $value
	 * @see Registry::put()
	 */
	public static function set($key, $value) {
		self::put($key, $value);
	}

	/**
	 * alias for put
	 * @param string $key
	 * @param mixed $value
	 * @see Registry::put()
	 */
	public static function push($key, $value) {
		self::put($key, $value);
	}

	/**
	 * get the value of the corresponding key
	 * @param string $key
	 * @return mixed
	 * @throws \InvalidArgumentException
	 * @throws \Exception
	 */
	public static function get($key)  {
		if(!is_string($key) || trim($key) == '')
			throw new \InvalidArgumentException('$key must be a valid string');
		
		if(!array_key_exists($key, self::$values))
			throw new \Exception("Registry does not have a key with value: {$key}");
		
		return self::$values[$key];
	}
	
	/**
	 * alias of get
	 * @param string $key
	 * @return mixed
	 * @see Registryl::get()
	 */
	public static function pop($key) {
		return self::get($key);
	}
	
	/**
	 * alias of get
	 * @param string $key
	 * @return mixed
	 * @see Registryl::get()
	 */
	public static function pull($key) {
		return self::get($key);
	}
}

?>