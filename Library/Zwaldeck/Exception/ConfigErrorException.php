<?php
/**
 * Created by PhpStorm.
 * User: wout
 * Date: 7/18/14
 * Time: 2:03 PM
 */

namespace Zwaldeck\Exception;


class ConfigErrorException extends \Exception {

    /**
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message, $code = 0,\Exception $previous = null) {
        parent::__construct ( $message, $code, $previous );
    }
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

} 