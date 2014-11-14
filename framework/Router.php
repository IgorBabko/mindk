<?php
/**
 * File /framework/Router.php contains Router class which is used to resolve
 * what controller must be used to handle http request.
 *
 * PHP version 5
 *
 * @package Framework.
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

use Framework\MatchedRoute;

/**
 * Class Router.
 *
 * Class represents routing system defining controller and its action
 * to handle the http request depending on url.
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Router
{

    /**
     * @var array|null $routeCollection Holds all routes defined in application
     */
    public $routeCollection = array();
    /**
     * @var string $host Host
     */
    public $host;

    /**
     * Router constructor.
     *
     * Constructor takes routeCollection to know all available paths in application.
     *
     * @param \Framework\RouteCollection|null $routeCollection Collection of all defined routes.
     *
     * @return \Framework\Router Router object.
     */
    public function __construct($routeCollection = null)
    {
        $this->host            = 'http://'.$_SERVER['HTTP_HOST'];
        $this->routeCollection = $routeCollection;
    }

    /**
     * Method to add route to routeCollection.
     *
     * @param string $routeName Name of new route.
     * @param array  $routeInfo Info about new route.
     *
     * @return void
     */
    public function addRoute($routeName, $routeInfo)
    {
        $this->routeCollection->add($routeName, $routeInfo);
    }

    /**
     * Method which defines matched route.
     *
     * Method runs foreach loop to take each route and check it for matching with request. It's necessary to check
     * whether current route has some http method restrictions. Empty array which is supposed to hold all allowed http methods
     * for route means that any method is allowed, but if http methods array specified and current http request doesn't match
     * any of methods from method array loop gets next iteration with next route to check.
     * If current route holds any placeholders they have to be replaced with its regular expressions from requirements array.
     * If all specified parameters in url satisfy its regular expressions MatchedRoute object instantiates
     * according to the parameters taken from url.
     * When there's no placeholders in url it simply compares url with each route pattern and if match happens
     * the MatchedRoute object instantiates based on route pattern of which has matched with url.
     * If method could not detect any valid route from routeCollection for specified url it instantiates the MatchedRoute object
     * based on ErrorController to inform of error.
     *
     * @return \Framework\MatchedRoute Route which will handle http request.
     */
    public function matchCurrentRequest()
    {
        foreach ($this->routeCollection->routes as $routeName => $routeInfo) {

            if (isset($routeInfo->requirements['_method']) && $routeInfo->requirements['_method'] !== $_SERVER['REQUEST_METHOD']) {
                continue;
            }

            $url = '/'.trim($_SERVER['REQUEST_URI'], '/');

            if (strpos($routeInfo->pattern, ':') !== false) {
                $pattern = $routeInfo->pattern;
                preg_match_all('/:(\w+)/', $pattern, $paramNames);
                $paramNames = $paramNames[1];

                foreach ($paramNames as $paramName) {
                    if (isset($routeInfo->requirements[$paramName])) {
                        $pattern = preg_replace('/:(\w+)/', '('.$routeInfo->requirements[$paramName].')', $pattern, 1);
                    }
                }

                $pattern = ltrim($pattern, '/');
                $pattern = '^/'.$pattern.'$';
                $pattern = str_replace('/', '\/', $pattern);
                $pattern = '/'.$pattern.'/';


                if (preg_match($pattern, $url, $params) !== 0) {

                    array_shift($params);
                    DI::setParams('route', array('routeInfo' => (array)$routeInfo));
                    DI::setParams('matchedRoute', array('params' => $params));

                    return DI::resolve('matchedRoute');
                }
            }

            if ($routeInfo->pattern === $url) {
                DI::setParams('route', array('routeInfo' => (array)$routeInfo));
                return DI::resolve('matchedRoute');
            }
        }

        $matchedRoute = new MatchedRoute();
        $matchedRoute->setController('Framework\\ErrorController');
        $matchedRoute->setParameters(array('errorCode' => '404'));
        return $matchedRoute;
    }


    /**
     * Method to generate url according to given parameters and route name.
     *
     * Method generates url according to specified name (first parameter)
     * and list of parameters of the route (second parameter). If no such name of route is found
     * in routeCollection exceptions throws. If search of route by name succeed it gets pattern of found route.
     * In case parameters array for url to be generated isn't set then method immediately returns pattern but
     * when parameters array isn't empty it replaces all placeholders from pattern on its particular value from
     * parameters array and only then generated url returns.
     *
     * @param string $routeName Name of route to generate.
     * @param array  $params    Params for route to generate.
     *
     * @return string Generated url.
     * @throws \Exception If no routes in routeCollection with given name.
     */
    public function generateUrl($routeName = 'hello', $params = array())
    {

        if (!isset($this->routeCollection->routes[$routeName])) {
            throw new \Exception("No route with the name $routeName has been found.");
        }

        //\info(array_keys($this->routeCollection->routes));

        $route = $this->routeCollection->routes[$routeName];
        $url   = $route->pattern;

        if ($params && preg_match_all('/:(\w+)/', $url, $param_keys)) {
            $param_keys = $param_keys[1];

            foreach ($param_keys as $key) {
                if (isset($params[$key])) {
                    $url = preg_replace('/:(\w+)/', $params[$key], $url, 1);
                }
            }
        }
        return $url;
    }
}