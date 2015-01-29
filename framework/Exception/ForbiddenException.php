<?php
/**
 * File /framework/exception/ForbiddenException.php contains ForbiddenException class
 * to represent exceptions that might occur when user tries to get access
 * to resource that is denied for him to see.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class ForbiddenException is used to represent exceptions that might occur when user tries to get access
 * to resource that is denied for him to see.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ForbiddenException extends FrameworkException
{
    /**
     * ForbiddenException constructor.
     *
     * @param  int    $code    Exception code.
     * @param  string $message Exception message.
     *
     * @return object ForbiddenException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}