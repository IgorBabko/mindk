<?php
/**
 * File /Framework/Exception/SafeSQLException.php contains SafeSQLException class
 * to represent exceptions related to SafeSQL class.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

require_once('FrameworkException.php');

/**
 * Class SafeSQLException is used to represent exceptions
 * that might happen while working with database.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class SafeSQLException extends FrameworkException
{
    /**
     * SafeSQLException constructor.
     *
     * @param string $code    Exception code.
     * @param string $message Exception message.
     *
     * @return \Framework\Exception\SafeSQLException SafeSQLException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}