<?php
/**
 * File /Framework/Application.php contains Application class (front controller)
 * from where application starts executing.
 *
 * PHP version 5
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

use Framework\DI\Service;
use Framework\Controller\ExceptionController;

require_once('Loader.php');

/**
 * Class Application - main class of the application (front controller).
 *
 * Application is a class that starts app and handles http request
 * defining particular controller and its action to call depending on url.
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Application
{
    /**
     * @static
     * @var \Framework\ExceptionController ExceptionController instance
     */
    public static $_exceptionController;
    /**
     * @static
     * @var \Framework\TemplateEngine TemplateEngine object
     */
    public static $_templateEngine;
    /**
     * @var \Framework\Controller $_controller Holds the chosen controller
     */
    private $_controller;
    /**
     * @var string $_action Name of the chosen method
     */
    private $_action;
    /**
     * @var array $_config App configurations
     */
    private $_config;
    /**
     * @var \Framework\Router $_router Holds router
     */
    private $_router;
    /**
     * @var \Framework\MatchedRoute $_router Holds matched route
     */
    private $_matchedRoute;
    /**
     * @var \Framework\Request $_request Request object that represents http request
     */
    private $_request;

    /**
     * Method is used to make full preparation before application startup.
     *
     * Method does next steps:
     *  - defines several constants;
     *  - reflects namespaces to its particular directories;
     *  - collects information about all needed services to successfully resolve all class dependencies.
     *
     * @throws \Framework\Exception\LoaderException
     *
     * @return \Framework\Application Application instance.
     */
    public static function instantiate()
    {
        define('CONFIG'   , __DIR__ . '/../app/config/config.php');
        define('ROUTES'   , __DIR__ . '/../app/config/routes.php');
        define('RESOLVERS', __DIR__ . '/resolvers.config.php'    );
        define('VIEWS'    , __DIR__ . '/../src/Blog/Views/'      );


        Loader::addNamespacePath('Blog\\Controller\\'     , __DIR__ . '/../src/Blog/Controller/');
        Loader::addNamespacePath('Framework\\'            , __DIR__ . '/'                       );
        Loader::addNamespacePath('Framework\\Exception\\' , __DIR__ . '/Exception/'             );
        Loader::addNamespacePath('Framework\\Request\\'   , __DIR__ . '/Request/'               );
        Loader::addNamespacePath('Framework\\Response\\'  , __DIR__ . '/Response/'              );
        Loader::addNamespacePath('Framework\\DI\\'        , __DIR__ . '/DI/'                    );
        Loader::addNamespacePath('Framework\\Controller\\', __DIR__ . '/Controller/'            );
        Loader::addNamespacePath('Framework\\Validation\\', __DIR__ . '/Validation/'            );
        Loader::register();


        self::$_exceptionController = ExceptionController::getInstance();
        self::$_exceptionController->registerHandler();


        $resolvers = require RESOLVERS;
        Service::setService(
            'templateEngine',
            'TemplateEngine',
            $resolvers['templateEngine'],
            array('templateDir' => VIEWS),
            array()
        );
        Service::setService('route', 'Route', $resolvers['route'], array(), array());
        Service::setService(
            'routeCollection',
            'RouteCollection',
            $resolvers['routeCollection'],
            array('routes' => ROUTES),
            array()
        );
        Service::setService(
            'router',
            'Router',
            $resolvers['router'],
            array(),
            array('routeCollection' => 'RouteCollection')
        );
        Service::setService(
            'matchedRoute',
            'MatchedRoute',
            $resolvers['matchedRoute'],
            array('params' => null),
            array('route' => 'Route')
        );
        Service::setService(
            'application',
            'Application',
            $resolvers['application'],
            array('config' => CONFIG),
            array('router' => 'Router', 'templateEngine' => 'TemplateEngine')
        );

        return Service::Resolve('application');
    }

    /**
     * Application constructor.
     *
     * Constructor takes router and app configurations as parameters
     * and defines the matched router.
     *
     * @param \Framework\Router         $router         Router object.
     * @param \Framework\TemplateEngine $templateEngine TemplateEngine object.
     * @param string                    $config         App configurations.
     *
     * @return \Framework\Application Application object.
     */
    public function __construct($router, $templateEngine, $config)
    {
        if (file_exists($config)) {
            $this->_config = require($config);
        }

        self::$_templateEngine = $templateEngine;
        $this->_router         = $router;
        $this->_matchedRoute   = $this->_router->matchCurrentRequest();
        $this->_controller     = new $this->_matchedRoute->controller();
        $this->_action         = $this->_matchedRoute->action;
    }


    /**
     * The method to start the app.
     *
     * It calls the the method of the controller of matched route.
     *
     * @return void
     */
    public function run()
    {
        $controller = $this->_controller;
        $action     = $this->_action;
        $parameters = $this->_matchedRoute->parameters;
        $controller->$action($parameters);
    }

    /**
     * Method returns TemplateEngine instance.
     *
     * @static
     *
     * @TODO Add check whether self::_templateEngine exists.
     *
     * @return \Framework\TemplateEngine TemplateEngine instance.
     */
    public static function getTemplateEngine()
    {
        return self::$_templateEngine;
    }

    /**
     * Method to get the chosen controller.
     *
     * @return \Framework\Controller Chosen controller.
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * Method to get the chosen action of the chosen controller.
     *
     * @return string Chosen action of chosen controller.
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * Method to get the application router.
     *
     * @return \Framework\Router Router of app.
     */
    public function getRouter()
    {
        return $this->_router;
    }

    /**
     * Method to get the matched route.
     *
     * @return \Framework\MatchedRoute Matched route.
     */
    public function getMatchedRoute()
    {
        return $this->_matchedRoute;
    }
}