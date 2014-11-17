<?php
/**
 * File /Framework/Exception/CookieException.php contains CookieException class
 * to represent exceptions related to Cookie.
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
     * @param string $message Exception message.
     *
     * @return \Framework\Exception\CookieException CookieException instance.
     */
    function __construct($message)
    {
        $this->message = $message;
    }
}