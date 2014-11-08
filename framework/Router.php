<?php

namespace Framework;

class Router
{

    public $routeCollection = array();
    public $host;
    public $matcher;
    public $generator;

    public function __construct($routes)
    {

        $this->host            = 'http://'.$_SERVER['HTTP_HOST'];
        $this->routeCollection = new RouteCollection($routes);

        $this->matcher   = new UrlMatcher($this->routeCollection);
        $this->generator = new UrlGenerator();
    }

    public function addRoute($routeName, $routeInfo)
    {
        $this->routeCollection->add($routeName, $routeInfo);
    }

    public function matchCurrentRequest()
    {

        foreach ($this->routeCollection->routes as $routeName => $routeInfo) {

            if (isset($routeInfo->requirements['_method']) && $routeInfo->requirements['_method'] !== $_SERVER['REQUEST_METHOD']) {
                continue;
            }

            $url = $_SERVER['REQUEST_URI'];
            //echo $url;

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
                    return new \Framework\MatchedRoute($routeInfo, $params);
                }
            }

            if ($routeInfo->pattern === $url) {
                //echo 'route without any parameters is found';
                return new \Framework\MatchedRoute($routeInfo);
            }
        }

        //echo 'can\'t find the route';
        $matchedRoute = new MatchedRoute();
        $matchedRoute->setController('Framework\\ErrorController');
        $matchedRoute->setParams(array('errorCode' => '404'));
        return $matchedRoute;
    }


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