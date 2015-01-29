<?php
/**
 * File /framework/routing/Router.php contains Router class which is used to resolve
 * what controller must be used to handle http request.
 *
 * PHP version 5
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Routing;

use Framework\DI\Service;
use Framework\Exception\ForbiddenException;
use Framework\Exception\RouterException;
use Framework\Exception\HttpNotFoundException;
use Framework\Template\TemplateEngine;

/**
 * Class Router.
 * Default implementation of {@link RouterInterface}.
 *
 * Class represents routing system defining controller and its action
 * to handle the http request depending on url.
 *
 * @package Framework\Routing
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Router implements RouterInterface
{
    /**
     * @static
     * @var Router|null $_instance Router instance
     */
    private static $_instance = null;

    /**
     * @var RouteCollection $_routeCollection Holds all routes defined in application
     */
    private $_routeCollection;

    /**
     * @var string $_host Host
     */
    private $_host;

    /**
     * Router constructor.
     *
     * Constructor takes RouteCollection object to know all available paths in application.
     *
     * @param  \Framework\Routing\RouteCollection|null $routeCollection Collection of all defined routes.
     *
     * @return object Router.
     */
    private function __construct($routeCollection = null)
    {
        $this->_host            = 'http://'.$_SERVER['HTTP_HOST'];
        $this->_routeCollection = $routeCollection;
    }

    /**
     * Method to clone objects of its class.
     *
     * @return object Router.
     */
    private function __clone()
    {
    }

    /**
     * Method returns Router instance creating it if it's not been instantiated before
     * otherwise existed Router object will be returned.
     *
     * @param  \Framework\Routing\RouteCollection|null $routeCollection Collection of all defined routes.
     *
     * @return object Router.
     */
    public static function getInstance($routeCollection = null)
    {
        if (null === self::$_instance) {
            self::$_instance = new self($routeCollection);
        }
        return self::$_instance;
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteCollection()
    {
        return $this->_routeCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function setRouteCollection($routeCollection)
    {
        $this->_routeCollection = $routeCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function getHost()
    {
        return $this->_host;
    }

    /**
     * {@inheritdoc}
     */
    public function addRoute($routeName, Route $route)
    {
        $this->_routeCollection->setRoute($routeName, $route);
    }

    /**
     * {@inheritdoc}
     */
    public function matchCurrentRequest()
    {
        $request = Service::resolve('request');
        $url     = '/'.trim($request->getURI(), '/');

        $role = isset($_SESSION['user'])?strtoupper($_SESSION['user']['role']):'GUEST';

        $templateEngine = TemplateEngine::getInstance();
        $templateEngine->setData('router', $this);
        foreach ($this->_routeCollection->getRoutes() as $routeName => $routeInfo) {

            if (isset($routeInfo->getRequirements()['_ajax']) && !$request->isAjax()) {
                continue;
            }

            if (isset($routeInfo->getRequirements()['_method']) && !$request->isMethod(
                    $routeInfo->getRequirements()['_method']
                )
            ) {
                continue;
            }

            if (strpos($routeInfo->getPattern(), '{') !== false) {
                $pattern = $routeInfo->getPattern();
                preg_match_all('/{(\w+)}/', $pattern, $paramNames);
                $paramNames = $paramNames[1];

                foreach ($paramNames as $paramName) {
                    if (isset($routeInfo->getRequirements()[$paramName])) {
                        $pattern = preg_replace(
                            '/{(\w+)}/',
                            '('.$routeInfo->getRequirements()[$paramName].')',
                            $pattern,
                            1
                        );
                    }
                }

                $pattern = ltrim($pattern, '/');
                $pattern = '^/'.$pattern.'$';
                $pattern = str_replace('/', '\/', $pattern);
                $pattern = '/'.$pattern.'/';

                if (preg_match($pattern, $url, $params) != 0) {

                    if ($routeInfo->getSecurity() != null && !in_array($role, $routeInfo->getSecurity())) {
                        throw new ForbiddenException(403, "Access denied");
                    }

                    array_shift($params);
                    $routeInfo->setParameters($params);
                    $templateEngine->setData('activeRoute', $routeName);
                    $templateEngine->setData('params', $params);
                    return $routeInfo;
                }
            }

            if ($routeInfo->getPattern() === $url) {

                if ($routeInfo->getSecurity() != null && !in_array($role, $routeInfo->getSecurity())) {
                    throw new ForbiddenException(403, "Access denied");
                }

                $templateEngine->setData('activeRoute', $routeName);
                return $routeInfo;
            }
        }
        throw new HttpNotFoundException(404, "Not Found");
    }

    /**
     * {@inheritdoc}
     */
    public function generateRoute($routeName = 'hello', $params = array())
    {
        if (!isset($this->_routeCollection->getRoutes()[$routeName])) {
            throw new RouterException(
                500, "<strong>Internal server error:</strong> no route with name '$routeName' has been found."
            );
        }

        $route = $this->_routeCollection->getRoutes()[$routeName];
        $url   = $route->getPattern();

        if ($params && preg_match_all('/{(\w+)}/', $url, $param_keys)) {
            $param_keys = $param_keys[1];

            foreach ($param_keys as $key) {
                if (isset($params[$key])) {
                    $url = preg_replace('/{(\w+)}/', $params[$key], $url, 1);
                }
            }
        }
        return $url;
    }
}