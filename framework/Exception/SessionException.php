<?php
/**
 * File /framework/exception/SessionException.php contains SessionException class
 * to represent exceptions related to session.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class SessionException is used to represent exceptions
 * that might happen working with session.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class SessionException extends FrameworkException
{
    /**
     * SessionException constructor.
     *
     * @param  int    $code    Exception code.
     * @param  string $message Exception message.
     *
     * @return object SessionException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}