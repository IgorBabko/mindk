<?php
/**
 * File /framework/exception/CsrfTokenException.php contains CsrfTokenException class
 * to represent exceptions that can occur while creating form.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class CsrfTokenException is used to represent exceptions
 * that can occur while creating form.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class CsrfTokenException extends FrameworkException
{
    /**
     * CsrfTokenException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\CsrfTokenException CsrfTokenException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}