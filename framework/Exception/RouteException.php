<?php
/**
 * File /framework/exception/RouteException.php contains RouteException class
 * to represent exceptions related ro routes.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class RouteException is used to represent exceptions
 * related to routes.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class RouteException extends FrameworkException
{
    /**
     * RouteException constructor.
     *
     * @param  int    $code    Exception code.
     * @param  string $message Exception message.
     *
     * @return \Framework\Exception\RouteException RouteException instance.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}