<?php
/**
 * File /framework/exception/TemplateEngineException.php contains TemplateEngineException class
 * to represent exceptions related to rendering views.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class TemplateEngineException is used to represent exceptions
 * that might happen while rendering view.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class TemplateEngineException extends FrameworkException
{
    /**
     * TemplateEngineException constructor.
     *
     * @param  int $code Exception code.
     * @param  string $message Exception message.
     *
     * @return object TemplateEngineException.
     */
    function __construct($code, $message)
    {
        parent::__construct($code, $message);
    }
}