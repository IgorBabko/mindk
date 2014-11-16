<?php
/**
 * File /Framework/ErrorController.php contains ErrorController class
 * which is going to be used once error is occured.
 *
 * PHP version 5
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

use Framework\Controller\Controller;

/**
 * Class ErrorController is responsible to render Views for different types of errors.
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ErrorController extends Controller
{
    /**
     * @var array $errorList Holds error codes as keys and its descriptions as values
     */
    public static $errorList = array(
        '400' => 'Bad Request',
        '401' => 'Unauthorized',
        '403' => 'Forbidden',
        '404' => 'Not Found',
        '500' => 'Internal Server Error'
    );

    /**
     * Method specifies parameters to error view and calls method to render error view with these parameters.
     *
     * @param string $errorInfo Information of error (code, description).
     *
     * @return void
     */
    public function indexAction($errorInfo)
    {
        //Application::reset();
        $templateEngine = Application::getTemplateEngine();

        $errorCode    = $errorInfo['errorCode'];
        $errorMessage = self::$errorList[$errorCode];
        $templateEngine->setData('code',    $errorCode);
        $templateEngine->setData('message', $errorMessage);
        $templateEngine->render('/500');
        //$this->render('/500.html.php');
    }
}