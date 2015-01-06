<?php
/**
 * File /framework/application/App.php contains Application class (front controller)
 * from where application starts executing.
 *
 * PHP version 5
 *
 * @package Framework\Application
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Application;

use Framework\Config\Config;
use Framework\DI\Service;
use Framework\Exception\ApplicationException;
use Framework\Loader\Loader;
use Framework\Util\ExceptionHandler;

/**
 * Class App - main class of the application (front controller).
 * Default implementation of {@link AppInterface}.
 *
 * App is a class that starts app and handles http request
 * defining particular controller and its action to call depending on url.
 *
 * @package Framework\Application
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class App implements AppInterface
{
//    /////////////////////////////////////////////////////////////////////////////////
//    /**
//     * @static
//     * @var \Framework\Controller\ExceptionController ExceptionController instance
//     */
//    public static $_exceptionController;
//
//    /**
//     * @static
//     * @var \Framework\Template\TemplateEngine TemplateEngine object
//     */
//    public static $_templateEngine;
//
//    /**
//     * @var \Framework\Controller\Controller $_controller Holds the chosen controller
//     */
//    private $_controller;
//
//    /**
//     * @var string $_action Name of the chosen method
//     */
//    private $_action;
//
//    /**
//     * @var array $_config App configurations
//     */
//    private $_config;
//
//    /**
//     * @var \Framework\Routing\Router $_router Holds router
//     */
//    private $_router;
//
//    /**
//     * @var \Framework\Routing\MatchedRoute $_router Holds matched route
//     */
//    private $_matchedRoute;
//    //////////////////////////////////////////////////////////////////////////////////

    /**
     * Method is used to make full preparation before application startup.
     *
     * Method does next steps:
     *  - defines several constants;
     *  - reflects namespaces to its particular directories;
     *  - collects information about all needed services to successfully resolve all class dependencies.
     *
     * @throws \Framework\Exception\LoaderException LoaderException instance.
     *
     * @return \Framework\Application Application instance.
     */
    public static function instantiate()
    {
        Loader::addNamespacePath('Framework\\'                        , __DIR__ . '/'                      );
        Loader::addNamespacePath('Framework\\Application\\'           , __DIR__ . '/application/'          );
        Loader::addNamespacePath('Framework\\Config\\'                , __DIR__ . '/config/'               );
        Loader::addNamespacePath('Framework\\Database\\'              , __DIR__ . '/database/'             );
        Loader::addNamespacePath('Framework\\Exception\\'             , __DIR__ . '/exception/'            );
        Loader::addNamespacePath('Framework\\Routing\\'               , __DIR__ . '/routing/'              );
        Loader::addNamespacePath('Framework\\Request\\'               , __DIR__ . '/request/'              );
        Loader::addNamespacePath('Framework\\Response\\'              , __DIR__ . '/response/'             );
        Loader::addNamespacePath('Framework\\Session\\'               , __DIR__ . '/session/'              );
        Loader::addNamespacePath('Framework\\Cookie\\'                , __DIR__ . '/cookie/'               );
        Loader::addNamespacePath('Framework\\DI\\'                    , __DIR__ . '/DI/'                   );
        Loader::addNamespacePath('Framework\\Controller\\'            , __DIR__ . '/controller/'           );
        Loader::addNamespacePath('Framework\\Model\\'                 , __DIR__ . '/model/'                );
        Loader::addNamespacePath('Framework\\Validation\\'            , __DIR__ . '/validation/'           );
        Loader::addNamespacePath('Framework\\Template\\'              , __DIR__ . '/template/'             );
        Loader::addNamespacePath('Framework\\Sanitization\\'          , __DIR__ . '/sanitization/'         );
        Loader::addNamespacePath('Framework\\Security\\'              , __DIR__ . '/security/'             );
        Loader::addNamespacePath('Framework\\Util\\'                  , __DIR__ . '/util/'                 );
        Loader::addNamespacePath('Framework\\Validation\\Constraint\\', __DIR__ . '/validation/constraint/');
        Loader::addNamespacePath('Framework\\Sanitization\\Filter\\'  , __DIR__ . '/sanitization/filter/'  );
        Loader::register();


        //self::$_exceptionController = ExceptionController::getInstance();
        ExceptionHandler::registerHandler();


        $resolvers = require_once(RESOLVERS);
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
//        Service::setService(
//            'app',
//            'App',
//            $resolvers['application'],
//            array('config' => CONF),
//            array('router' => 'Router', 'templateEngine' => 'TemplateEngine')
//        );

        //return Service::Resolve('application');
    }

    /**
     * Application constructor.
     *
     * Constructor takes router and app configurations as parameters
     * and defines the matched router.
     *
     * @param \Framework\Routing\Router          $router         Router object.
     * @param \Framework\Template\TemplateEngine $templateEngine TemplateEngine object.
     * @param string                             $config         App configurations.
     *
     * @return \Framework\Application Application object.
     */
//    public function __construct(/*$router, $templateEngine, $config*/)
//    {
//        if (file_exists(CONF)) {
//            Config::setConfig(CONF);
//            //$this->_config = require_once($config);
//
//            //self::$_templateEngine = $templateEngine;
//
//
//
//
//            //$this->_router         = $router;
//            //$this->_matchedRoute   = $this->_router->matchCurrentRequest();
//
//
//
//            $this->_controller     = new $controllerName;
//            $this->_action         = $actionName;
//        } else {
//            throw new ApplicationException("001", "Config file '$config' does not exist'");
//        }
//    }


    /**
     * The method to start the app.
     *
     * It calls the the method of the controller of matched route.
     *
     * @return void
     */
    public static function run()
    {
        if (file_exists(CONF)) {
            Config::setConfig(CONF);

            $router       = Service::resolve('router');
            $matchedRoute = $router->matchCurrentRequest();

            $controller   = $matchedRoute->getControllerName() . "Controller";
            $action       = $matchedRoute->getActionName()     . "Action";
            $parameters   = $matchedRoute->getParameters();

            $controller->$action($parameters);
        } else {
            throw new ApplicationException("001", "Config file '" . CONF . "' does not exist'");
        }
    }

//    /**
//     * Method returns TemplateEngine instance.
//     *
//     * @static
//     *
//     * @TODO Add check whether self::_templateEngine exists.
//     *
//     * @return \Framework\Template\TemplateEngine TemplateEngine instance.
//     */
//    public static function getTemplateEngine()
//    {
//        return self::$_templateEngine;
//    }
//
//    /**
//     * Method to get the chosen controller.
//     *
//     * @return \Framework\Controller\Controller Chosen controller.
//     */
//    public function getController()
//    {
//        return $this->_controller;
//    }
//
//    /**
//     * Method to get the chosen action of the chosen controller.
//     *
//     * @return string Chosen action of chosen controller.
//     */
//    public function getAction()
//    {
//        return $this->_action;
//    }
//
//    /**
//     * Method to get the application router.
//     *
//     * @return \Framework\Routing\Router Router of app.
//     */
//    public function getRouter()
//    {
//        return $this->_router;
//    }
//
//    /**
//     * Method to get the matched route.
//     *
//     * @return \Framework\Routing\MatchedRoute Matched route.
//     */
//    public function getMatchedRoute()
//    {
//        return $this->_matchedRoute;
//    }
}