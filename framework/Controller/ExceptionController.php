<?php
/**
 * File /Framework/Controller/ExceptionController.php contains ExceptionController class
 * to handle all exceptions occurred in application.
 *
 * PHP version 5
 *
 * @package Framework\Controller
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Controller;

use Framework\Application;

/**
 * Class ExceptionController.
 *
 * Class is based on singleton design pattern and its "handle" method catches all
 * unhandled exceptions and serves it respectively.
 *
 * @package Framework\Controller
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ExceptionController extends Controller
{
    /**
     * @var \Framework\Controller\ExceptionController|null ExceptionController instance.
     */
    public static $_instance = null;

    /**
     * @var \Framework\Exception\FrameworkException|null Occurred exception.
     */
    protected $exception = null;

    /**
     * ExceptionController constructor is private to deny creating objects outside of the class.
     *
     * @return \Framework\Controller\ExceptionController ExceptionController instance.
     */
    private function __construct()
    {
    }

    /**
     * Method to clone objects of its class. It's private to deny cloning objects outside of the class.
     *
     * @return \Framework\Controller\ExceptionController ExceptionController instance.
     */
    private function __clone()
    {
    }

    /**
     * Method returns ExceptionController instance creating it if it's not been instantiated before
     * otherwise existed ExceptionController will be returned.
     *
     * @return \Framework\Controller\ExceptionController ExceptionController instance.
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    /**
     * It applies to register "handle" method as handler for unhandled exceptions.
     *
     * @return void
     */
    public function registerHandler()
    {
        set_exception_handler(array($this, 'handle'));
    }

    /**
     * Method to restore exception handler.
     *
     * @return void
     */
    public function unregisterHandler()
    {
        restore_exception_handler();
    }

    /**
     * Method is registered as unhandled exceptions handler using function set_exception_handler.
     *
     * It catches exception and gets information about this exception into templateEngine data
     * to have ability using info of exception in the view.
     *
     * @param \Framework\Exception\FrameworkException $exception Unhandled exception.
     *
     * @return void
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