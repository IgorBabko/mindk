<?php
/**
 * File /Framework/Exception/QueryBuilderException.php contains QueryBuilderException class
 * to represent exceptions related to QueryBuilder class.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class QueryBuilderException is used to represent exceptions
 * that might happen while creating sql request.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class QueryBuilderException extends FrameworkException
{
    /**
     * QueryBuilderException constructor.
     *
     * @param string $code    Exception code.
     * @param string $message Exception message.
     *
     * @return \Framework\Exception\QueryBuilderException QueryBuilderException instance.
     */
    function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}