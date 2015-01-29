<?php
/**
 * File /framework/exception/RouterException.php contains RouterException class
 * to represent exceptions related to router.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class RouterException is used to represent exceptions
 * that might happen while searching route.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class RouterException extends FrameworkException
{
    /**
     * RouterException constructor.
     *
     * @param  int    $code    Exception code.
     * @param  string $message Exception message.
     *
     * @return object RouterException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}