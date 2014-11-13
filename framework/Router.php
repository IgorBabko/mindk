<?php
/**
 * /framework/Router.php contains Router class
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
     * @param \Framework\RouteCollection | null $routeCollection Collection of all defined routes
     */
    public function __construct($routeCollection = null)
    {
        $this->host            = 'http://'.$_SERVER['HTTP_HOST'];
        $this->routeCollection = $routeCollection;
    }

    /**
     * @param $routeName
     * @param $routeInfo
     */
    public function addRoute($routeName, $routeInfo)
    {
        $this->routeCollection->add($routeName, $routeInfo);
    }

    /**
     * @return MatchedRoute
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

                //echo '--------------------' . $pattern . '<br />';
                //echo '--------------------' . $url . '<br />';

                if (preg_match($pattern, $url, $params) !== 0) {

                    array_shift($params);
                    echo '<pre>';
                    print_r($routeInfo);
                    echo '</pre>';
                    DI::setParams('route', array('routeInfo' => (array)$routeInfo));
                    DI::setParams('matchedRoute', array('params' => $params));

                    return DI::resolve('matchedRoute');//new MatchedRoute($routeInfo, $params);
                }
            }

            if ($routeInfo->pattern === $url) {
                //echo 'route without any parameters is found';
                DI::setParams('route', array('routeInfo' => (array)$routeInfo));
                return DI::resolve('matchedRoute');
            }
        }

        //echo 'can\'t find the route';
        //DI::setParams('route', array('controller' => 'Framework\\ErrorController', 'action' => 'index'));
        //DI::setParams('matchedRoute', array('params' => array('errorCode' => '404')));
        $matchedRoute = new MatchedRoute();
        $matchedRoute->setController('Framework\\ErrorController');
        $matchedRoute->setParameters(array('errorCode' => '404'));
        return $matchedRoute;
    }


    /**
     * @param string $routeName
     * @param array  $params
     *
     * @return mixed
     * @throws \Exception
     */
    public function generateUrl($routeName = 'hello', $params = array())
    {

        if (!isset($this->routeCollection->routes[$routeName])) {
            throw new \Exception("No route with the name $routeName has been found.");
        }

        \info(array_keys($this->routeCollection->routes));

        $route = $this->routeCollection->routes[$routeName];
        $url   = $route->pattern;
        //echo $url;

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