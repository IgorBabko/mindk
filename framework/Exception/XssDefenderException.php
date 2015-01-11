<?php
/**
 * File /framework/exception/XssDefenderException.php contains XssDefenderException class
 * to represent exceptions that can occur while filtering data to prevent XSS attacks.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class XssDefenderException is used to represent exceptions
 * that can occur while filtering data to prevent XSS attacks.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class XssDefenderException extends FrameworkException
{
    /**
     * XssDefenderException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\XssDefenderException XssDefenderException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}