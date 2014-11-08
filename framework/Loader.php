<?php

namespace Framework;

class Loader
{

    private static $_namespacePath = array();

    public static function addNamespacePath($namespace, $namespacePath)
    {
        self::$_namespacePath[$namespace] = $namespacePath;
    }

    public static function loadController($controllerName, $params = null, $instantiate = true)
    {

        $controllerFile = self::$_namespacePath['Blog\\Controller\\'].$controllerName.'.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        }

        if ($instantiate) {
            $className = 'Blog\\Controller\\'.$controllerName;
            return new $className();
        }
    }

    public static function laodModel($modelName, $params = null, $instantiate = true)
    {

        $modelFile = self::$_namespacePath['Blog\\Model\\'].$modelName.'.php';

        if (file_exists($modelFile)) {
            require_once $modelFile;
        }

        if ($instantiate) {
            $className = 'Blog\\Model\\'.$modelName;
            return new $className();
        }
    }

    public static function loadCoreComponent($coreClassName, $params = null, $instantiate = true)
    {

        $coreClassFile = self::$_namespacePath["Framework\\"].$coreClassName.'.php';

        if (file_exists($coreClassFile)) {
            require_once $coreClassFile;
        }

        if ($instantiate) {
            $className = "Framework\\".$coreClassName;
            if (isset($params)) {
                return new $className($params);
            } else {
                return new $className();
            }
        }
    }
}