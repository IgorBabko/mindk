<?php
/**
 * File /framework/application/App.php contains App class (front controller)
 * from where application starts executing.
 *
 * PHP version 5
 *
 * @package Framework\Application
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Application;

use Framework\Config\Config;
use Framework\Cookie\Cookie;
use Framework\Database\SafeSQL;
use Framework\DI\Service;
use Framework\Exception\AppException;
use Framework\Exception\ConfigException;
use Framework\Loader\Loader;
use Framework\Model\ActiveRecord;
use Framework\Request\Request;
use Framework\Response\JsonResponse;
use Framework\Response\Response;
use Framework\Response\ResponseRedirect;
use Framework\Routing\Route;
use Framework\Routing\RouteCollection;
use Framework\Routing\Router;
use Framework\Session\Session;
use Framework\Template\TemplateEngine;
use Framework\Util\ExceptionHandler;
use Framework\Util\FormBuilder;
use Framework\Util\QueryBuilder;

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
    /**
     * @var object $_dbConnection Database connection
     */
    private static $_dbConnection;

    /**
     * Method to get database connection.
     *
     * @return SafeSQL Database connection.
     */
    public static function getDbConnection()
    {
        return self::$_dbConnection;
    }

    /**
     * Method to set database connection object.
     *
     * @param  object $dbConnection Database connection.
     *
     * @throws AppException AppException instance.
     *
     * @return void
     */
    public static function dbConnect($dbConnection)
    {
        if (is_object($dbConnection)) {
            self::$_dbConnection = $dbConnection;
        } else {
            $parameterType = gettype($dbConnection);
            throw new AppException(
                "001", "Parameter for App::setDbConnection method must be 'object', '$parameterType' is given"
            );
        }
    }

    /**
     * Method is used to make full preparation before application startup.
     *
     * Method does next steps:
     *     - reflects namespaces to its particular directories and sets loader;
     *     - establishes app configurations;
     *     - sets exception handler for uncaught exceptions;
     *     - collects information about all needed services to successfully resolve all class dependencies;
     *     - establishes database connection.
     *
     * @throws AppException    AppException    instance.
     * @throws ConfigException ConfigException instance.
     *
     * @return void
     */
    public static function init()
    {
        if (!file_exists(CONF)) {
            throw new AppException("001", "Config file '" . CONF . "' does not exist'");
        }

        Loader::addNamespacePath('Framework\\Application\\'           , __DIR__ . '/../application/'          );
        Loader::addNamespacePath('Framework\\Config\\'                , __DIR__ . '/../config/'               );
        Loader::addNamespacePath('Framework\\Database\\'              , __DIR__ . '/../database/'             );
        Loader::addNamespacePath('Framework\\Exception\\'             , __DIR__ . '/../exception/'            );
        Loader::addNamespacePath('Framework\\Routing\\'               , __DIR__ . '/../routing/'              );
        Loader::addNamespacePath('Framework\\Request\\'               , __DIR__ . '/../request/'              );
        Loader::addNamespacePath('Framework\\Response\\'              , __DIR__ . '/../response/'             );
        Loader::addNamespacePath('Framework\\Session\\'               , __DIR__ . '/../session/'              );
        Loader::addNamespacePath('Framework\\Cookie\\'                , __DIR__ . '/../cookie/'               );
        Loader::addNamespacePath('Framework\\DI\\'                    , __DIR__ . '/../DI/'                   );
        Loader::addNamespacePath('Framework\\Controller\\'            , __DIR__ . '/../controller/'           );
        Loader::addNamespacePath('Framework\\Model\\'                 , __DIR__ . '/../model/'                );
        Loader::addNamespacePath('Framework\\Validation\\'            , __DIR__ . '/../validation/'           );
        Loader::addNamespacePath('Framework\\Template\\'              , __DIR__ . '/../template/'             );
        Loader::addNamespacePath('Framework\\Sanitization\\'          , __DIR__ . '/../sanitization/'         );
        Loader::addNamespacePath('Framework\\Security\\'              , __DIR__ . '/../security/'             );
        Loader::addNamespacePath('Framework\\Util\\'                  , __DIR__ . '/../util/'                 );
        Loader::addNamespacePath('Framework\\Validation\\Constraint\\', __DIR__ . '/../validation/constraint/');
        Loader::addNamespacePath('Framework\\Sanitization\\Filter\\'  , __DIR__ . '/../sanitization/filter/'  );

        Loader::register();
        Config::setConfig(CONF);
        ExceptionHandler::registerHandler();

        Service::setService(
            'templateEngine',
            'TemplateEngine',
            function () {
                return TemplateEngine::getInstance();
            }
        );

        Service::setService(
            'route',
            'Route',
            function ($params = array()) {
                return new Route($params['routeInfo']);
            }
        );

        Service::setService(
            'routeCollection',
            'RouteCollection',
            function ($params = array()) {
                $routes          = array();
                $routeCollection = null;
                if (file_exists($params['routes'])) {
                    $routes          = require($params['routes']);
                    $routeCollection = RouteCollection::getInstance();
                }
                foreach ($routes as $routeName => $routeInfo) {
                    Service::setParams('route', array('routeInfo' => $routeInfo));
                    $routeCollection->setRoute($routeName, Service::resolve('route'));
                }
                return $routeCollection;
            },
            array('routes' => ROUTES)
        );

        Service::setService(
            'router',
            'Router',
            function ($params = array()) {
                return Router::getInstance($params['routeCollection']);
            },
            array(),
            array('routeCollection' => 'RouteCollection')
        );

        Service::setService(
            'request',
            'Request',
            function ($params = array()) {
                return Request::getInstance($params['session'], $params['cookie']);
            },
            array(),
            array('session' => 'Session', 'cookie' => 'Cookie')
        );

        Service::setService(
            'response',
            'Response',
            function ($params = array()) {
                return Response::getInstance($params['session'], $params['cookie']);
            },
            array(),
            array('session' => 'Session', 'cookie' => 'Cookie')
        );

        Service::setService(
            'jsonResponse',
            'JsonResponse',
            function () {
                return JsonResponse::getInstance();
            }
        );

        Service::setService(
            'responseRedirect',
            'ResponseRedirect',
            function () {
                return ResponseRedirect::getInstance();
            }
        );

        Service::setService(
            'cookie',
            'Cookie',
            function () {
                return Cookie::getInstance();
            }
        );

        Service::setService(
            'session',
            'Session',
            function () {
                return Session::getInstance();
            }
        );

        Service::setService(
            'dbConnection',
            'dbConnection',
            function ($params = array()) {
                return new SafeSql(
                    $params['user'],
                    $params['password'],
                    $params['dbname'],
                    $params['engine'],
                    $params['host'],
                    $params['charset']
                );
            },
            array(
                'user'     => Config::getSetting('pdo/user'),
                'password' => Config::getSetting('pdo/password'),
                'dbname'   => Config::getSetting('pdo/dbname'),
                'engine'   => Config::getSetting('pdo/engine'),
                'host'     => Config::getSetting('pdo/host'),
                'charset'  => Config::getSetting('pdo/charset')
            )
        );

        Service::setService(
            'formBuilder',
            'FormBuilder',
            function () {
                return new FormBuilder();
            }
        );

        Service::setService(
            'queryBuilder',
            'QueryBuilder',
            function () {
                return new QueryBuilder();
            }
        );

        self::$_dbConnection = Service::resolve('dbConnection');

        ActiveRecord::setDbConnection(self::$_dbConnection);
        ActiveRecord::setQueryBuilder(Service::resolve('queryBuilder'));
    }

    /**
     * Method to start the app.
     *
     * It defines the route and calls particular controller's action of matched route.
     *
     * @throws \Framework\Exception\ServiceException ServiceException instance.
     *
     * @return void
     */
    public static function run()
    {
        $router         = Service::resolve('router');
        $matchedRoute   = $router->matchCurrentRequest();
        $controllerName = $matchedRoute->getControllerName();
        $controller     = new $controllerName();

        $action         = $matchedRoute->getActionName() . "Action";
        $parameters     = $matchedRoute->getParameters();

        $controller->$action($parameters);
    }
}