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

use Framework\Application;

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
     * @var \Framework\Util\ExceptionHandler|null $_instance ExceptionHandler instance
     */
    private static $_instance = null;

    /**
     * @var \Framework\Exception\FrameworkException|null $_exception Occurred exception
     */
    private $_exception = null;

    /**
     * ExceptionHandler constructor is private to deny creating objects outside of the class.
     *
     * @return \Framework\Util\ExceptionHandler ExceptionHandler instance.
     */
    private function __construct()
    {
    }

    /**
     * Method to clone objects of its class. It's private to deny cloning objects outside of the class.
     *
     * @return \Framework\Util\ExceptionHandler ExceptionHandler instance.
     */
    private function __clone()
    {
    }

    /**
     * Method returns ExceptionHandler instance creating it if it's not been instantiated before
     * otherwise existed ExceptionHandler will be returned.
     *
     * @return \Framework\Util\ExceptionHandler ExceptionHandler instance.
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * {@inheritdoc}
     */
    public function getException()
    {
        return $this->_exception;
    }

    /**
     * {@inheritdoc}
     */
    public function registerHandler()
    {
        set_exception_handler(array($this, 'handle'));
    }

    /**
     * {@inheritdoc}
     */
    public function unregisterHandler()
    {
        restore_exception_handler();
    }

    /**
     * {@inheritdoc}
     */
    public function handle($exception)
    {
        $templateEngine = Application::getTemplateEngine();

        $templateEngine->setData('code'   ,   $exception->getCode());
        $templateEngine->setData('message',   $exception->getMessage());
        $templateEngine->setData('type'   ,   get_class($exception));
        $templateEngine->setData('file'   ,   $exception->getFile());
        $templateEngine->setData('line'   ,   $exception->getLine());

        $templateEngine->render('exception.html.php');
    }
}