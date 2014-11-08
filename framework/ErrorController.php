<?php

namespace Framework;

class ErrorController extends Controller
{

    public static $errorInfo = array(
        '400' => 'Bad Request',
        '401' => 'Unauthorized',
        '403' => 'Forbidden',
        '404' => 'Not Found',
        '500' => 'Internal Server Error'
    );

    public function __construct()
    {
    }

    public function indexAction($params)
    {
        $errorDescription = self::$errorInfo[$params['errorCode']];
        //echo $errorDescription;
        $this->render($params['errorCode'].':'.$errorDescription);
    }
}