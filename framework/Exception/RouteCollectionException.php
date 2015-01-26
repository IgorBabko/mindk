<?php
/**
 * File /framework/exception/RouteCollectionException.php contains RouteCollectionException class
 * to represent exceptions related to RouteCollection class.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class RouteCollectionException is used to represent exceptions
 * related to RouteCollection class.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class RouteCollectionException extends FrameworkException
{
    /**
     * RouteCollectionException constructor.
     *
     * @param  int    $code    Exception code.
     * @param  string $message Exception message.
     *
     * @return \Framework\Exception\RouteCollectionException RouteCollectionException instance.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}