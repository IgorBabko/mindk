<?php
/**
 * File /framework/util/ExceptionHandler.php contains ExceptionHandler class
 * to handle all exceptions occurred in application.
 *
 * PHP version 5
 *
 * @package Framework\Util
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Util;

use Framework\Template\TemplateEngine;

/**
 * Class ExceptionHandler.
 * Default implementation of {@link ExceptionHandlerInterface}.
 *
 * Class is based on singleton design pattern and its "handle" method catches all
 * unhandled exceptions and serves it respectively.
 *
 * @package Framework\Util
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ExceptionHandler implements ExceptionHandlerInterface
{
    /**
     * @static
     * @var \Framework\Exception\FrameworkException|null $_exception Occurred exception
     */
    private static $_exception = null;

    /**
     * {@inheritdoc}
     */
    public static function getException()
    {
        return self::$_exception;
    }

    /**
     * {@inheritdoc}
     */
    public static function registerHandler()
    {
        set_exception_handler(array(__CLASS__, 'handle'));
    }

    /**
     * {@inheritdoc}
     */
    public static function unregisterHandler()
    {
        restore_exception_handler();
    }

    /**
     * {@inheritdoc}
     */
    public static function handle($exception)
    {
        $templateEngine = TemplateEngine::getInstance();
        $templateEngine->setData('exception', $exception);
        $templateEngine->render(BLOG_LAYOUT, BLOG_VIEWS . 'error.html.php');
    }
}