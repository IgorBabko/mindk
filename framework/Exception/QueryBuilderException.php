<?php
/**
 * File /framework/exception/QueryBuilderException.php contains QueryBuilderException class
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
     * @param  int    $code    Exception code.
     * @param  string $message Exception message.
     *
     * @return object QueryBuilderException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}