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
     * @param  int    $code    Exception code.
     * @param  string $message Exception message.
     *
     * @return object CsrfTokenException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}