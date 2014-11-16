<?php

namespace Framework\Controller;

use Framework\Application;

/**
 * Class ExceptionController
 *
 * @package Framework\Controller
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
     * ExceptionController constructor.
     *
     * @return \Framework\Controller\ExceptionController ExceptionController instance.
     */
    private function __construct()
    {
    }

    /**
     * Method to clone objects of its class.
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
     *
     */
    public function registerHandler()
    {
        set_exception_handler(array($this, 'handle'));
    }

    /**
     *
     */
    public function unregisterHandler()
    {
        restore_exception_handler();
    }

    /**
     * @param $exception
     */
    public function handle($exception)
    {
        $templateEngine = Application::getTemplateEngine();

        $templateEngine->setData('message',   $exception->getMessage());
        $templateEngine->setData('type'   ,   get_class($exception));
        $templateEngine->setData('file'   ,   $exception->getFile());
        $templateEngine->setData('line'   ,   $exception->getLine());

        $templateEngine->render('exception.html.php');
    }
}