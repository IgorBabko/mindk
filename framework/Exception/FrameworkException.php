<?php
/**
 * File /framework/exception/FrameworkException.php contains FrameworkException class
 * which is superclass for all exceptions.
 *
 * PHP version 5
 *
 * @package Famework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Exception;

/**
 * Class FrameworkException serves as superclass for all exceptions in application.
 * Default implementation of {@link FrameworkExceptionInterface}.
 *
 * @package Framework\Exception
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
abstract class FrameworkException extends \Exception implements FrameworkExceptionInterface
{
}