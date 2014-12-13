<?php
/**
 * File /Framework/Exception/SessionException.php contains SessionException class
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
     * @param string $code    Exception code.
     * @param string $message Exception message.
     *
     * @return \Framework\Exception\SessionException SessionException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}