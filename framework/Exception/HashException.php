<?php
/**
 * File /framework/exception/HashException.php contains HashException class
 * to represent exceptions that might happen hashing passwords.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class HashException is used to represent exceptions
 * that might happen hashing passwords.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class HashException extends FrameworkException
{
    /**
     * HashException constructor.
     *
     * @param  int    $code    Exception code.
     * @param  string $message Exception message.
     *
     * @return object HashException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}