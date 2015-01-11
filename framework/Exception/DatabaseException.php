<?php
/**
 * File /framework/exception/DatabaseException.php contains DatabaseException class
 * to represent exceptions related to database.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class DatabaseException is used to represent exceptions
 * that might happen working with database.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class DatabaseException extends FrameworkException
{
    /**
     * DatabaseException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\DatabaseException DatabaseException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}