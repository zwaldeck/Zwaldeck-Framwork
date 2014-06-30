<?php

namespace Zwaldeck\Exceptoin;

class NotImplementedYet extends \Exception {
	
	public function __construct() {
		parent::__construct('This class or method is not yet implemented.', 999, null);
	}
	
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}

?>