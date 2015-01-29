<?php
/**
 * File /framework/util/ExceptionHandlerInterface.php contains
 * ExceptionHandlerInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Util
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Util;

/**
 * Interface ExceptionHandlerInterface is used to be implemented by ExceptionHandler class.
 *
 * @api
 *
 * @package Framework\Util
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface ExceptionHandlerInterface
{
    /**
     * It applies in order to register "handle" method as handler for unhandled exceptions.
     *
     * @return void
     */
    public static function registerHandler();

    /**
     * Method to restore exception handler.
     *
     * @return void
     */
    public static function unregisterHandler();

    /**
     * Method is registered as unhandled exceptions handler using function set_exception_handler.
     *
     * It catches exception and passes it to the TemplateEngine::_data array
     * to have ability using info of exception inside the view.
     *
     * @param  \Framework\Exception\FrameworkException $exception Unhandled exception.
     *
     * @return void
     */
    public static function handle($exception);

    /**
     * Method to get occurred exception.
     *
     * @return object|null Framework exception.
     */
    public static function getException();
}