<?php
/**
 * Created by PhpStorm.
 * User: wout
 * Date: 7/11/14
 * Time: 2:52 PM
 */

namespace Zwaldeck\Exception;


class ElementNotFoundException extends \Exception {
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