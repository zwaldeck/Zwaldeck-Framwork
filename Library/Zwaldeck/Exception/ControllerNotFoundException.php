<?php

namespace Zwaldeck\Exception;

/**
 * 
 * @author Wout Schoovaerts
 *
 */
class ControllerNotFoundException extends Exception404 {
	/**
	 * 
	 * @param string $message
	 * @param number $code
	 * @param \Exception $previous
	 */
	public function __construct($message, $code = 0,\Exception $previous = null) {
		parent::__construct ( $message, $code, $previous );
	}
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}

?>