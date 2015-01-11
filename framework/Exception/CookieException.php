<?php
/**
 * File /framework/exception/CookieException.php contains CookieException class
 * to represent exceptions related to cookie.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class CookieException is used to represent exceptions
 * that might happen working with cookie.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class CookieException extends FrameworkException
{
    /**
     * CookieException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\CookieException CookieException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}