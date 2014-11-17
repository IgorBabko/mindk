<?php
/**
 * File /Framework/Exception/RequestException.php contains RequestException class
 * to represent exceptions related to http request.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class RequestException is used to represent exceptions
 * that might happen working with http request.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class RequestException extends FrameworkException
{
    /**
     * RequestException constructor.
     *
     * @param string $message Exception message.
     *
     * @return \Framework\Exception\RequestException RequestException instance.
     */
    function __construct($message)
    {
        $this->message = $message;
    }
}