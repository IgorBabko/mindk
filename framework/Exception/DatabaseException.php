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
     * @param  int $code Exception code.
     * @param  string $message Exception message.
     *
     * @return object DatabaseException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}