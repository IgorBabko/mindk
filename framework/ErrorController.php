<?php
/**
 * File /framework/ErrorController.php contains ErrorController class
 * which is going to be used once error is occured.
 *
 * PHP version 5
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

/**
 * Class ErrorController is responsible to render views for different types of errors.
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ErrorController extends Controller
{

    /**
     * @var array $errorInfo Holds error codes as keys and its descriptions as values
     */
    public static $errorInfo = array(
        '400' => 'Bad Request',
        '401' => 'Unauthorized',
        '403' => 'Forbidden',
        '404' => 'Not Found',
        '500' => 'Internal Server Error'
    );

    /**
     * Method specifies parameters to error view and calls method to render error view with these parameters.
     *
     * @param array $params Parameters array.
     *
     * @return void
     */
    public function indexAction($params)
    {
        $errorDescription = self::$errorInfo[$params['errorCode']];
        $this->render($params['errorCode'].':'.$errorDescription);
    }
}