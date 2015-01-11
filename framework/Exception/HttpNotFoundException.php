<?php
/**
 * File /framework/exception/HttpNotFoundException.php contains HttpNotFoundException class
 * to represent exceptions with code 404 (not found).
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class HttpNotFoundException is used to represent exceptions
 * that might happen when requested page is not found.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class HttpNotFoundException extends FrameworkException
{
    /**
     * HttpNotFoundException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\HttpNotFoundException HttpNotFoundException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}