<?php
/**
 * File /framework/exception/SafeSqlException.php contains SafeSqlException class
 * to represent exceptions related to SafeSql class.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class SafeSqlException is used to represent exceptions
 * that might happen while working with database.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class SafeSqlException extends FrameworkException
{
    /**
     * SafeSqlException constructor.
     *
     * @param  int $code Exception code.
     * @param  string $message Exception message.
     *
     * @return object SafeSqlException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}