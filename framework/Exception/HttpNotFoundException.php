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
     * @param  int $code Exception code.
     * @param  string $message Exception message.
     *
     * @return object HttpNotFoundException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}