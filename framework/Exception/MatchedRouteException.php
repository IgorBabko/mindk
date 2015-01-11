<?php
/**
 * File /framework/exception/MatchedRouteException.php contains MatchedRouteException class
 * to represent exceptions related to matched route.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class MatchedRouteException is used to represent exceptions
 * related to matched route.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class MatchedRouteException extends FrameworkException
{
    /**
     * MatchedRouteException constructor.
     *
     * @param  string $code    exception code.
     * @param  string $message exception message.
     *
     * @return \Framework\Exception\MatchedRouteException MatchedRouteException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}