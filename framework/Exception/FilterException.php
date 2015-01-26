<?php
/**
 * File /framework/exception/FilterException.php contains FilterException class
 * to represent exceptions of sanitization filters.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class FilterException is used to represent exceptions of sanitization filters.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class FilterException extends FrameworkException
{
    /**
     * FilterException constructor.
     *
     * @param  int    $code    Exception code
     * @param  string $message Exception message.
     *
     * @return \Framework\Exception\FilterException FilterException instance.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}