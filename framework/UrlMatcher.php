<?php

namespace Framework;

class UrlMatcher
{

    public $routeCollection;

    public $filters = array();

    public function __construct(\Framework\RouteCollection $routeCollection)
    {
        $this->routeCollection = $routeCollection;
    }

    public function match()
    {

        foreach ($this->routeCollection->routes as $routeName => $routeInfo) {

            if (isset($routeInfo->requirements['_method']) && $routeInfo->requirements['_method'] !== $_SERVER['REQUEST_METHOD']) {
                continue;
            }

            $url = $_SERVER['REQUEST_URI'];
            echo $url;

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

                echo '--------------------'.$pattern.'<br />';
                echo '--------------------'.$url.'<br />';
                if (preg_match($pattern, $url, $params) !== 0) {

                    array_shift($params);
                    echo '<pre>';
                    print_r($routeInfo);
                    echo '</pre>';
                    return new \Framework\MatchedRoute($routeInfo, $params);
                }
            }

            if ($routeInfo->pattern === $url) {
                echo 'route without any parameters is found!!!';
                return new \Framework\MatchedRoute($routeInfo);
            }
        }

        echo 'can\'t find the route';
        $matchedRoute = new \Framework\MatchedRoute();
        $matchedRoute->setController('Framework\\ErrorController');
        $matchedRoute->setParams(array('errorCode' => '404'));
        return $matchedRoute;
    }
}