<?php
/**
 * File /framework/DI/Service.php contains Service class which allows simply resolve all dependencies
 * instantiating particular object.
 *
 * PHP version 5
 *
 * @package Framework\DI
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\DI;

use Framework\Exception\ServiceException;

/**
 * Class Service for representing and storing class dependencies.
 * Default implementation of {@link ServiceInterface}.
 *
 * @package Framework\DI
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Service implements ServiceInterface
{
    /**
     * @static
     * @var array $_services Holds all needed information of services used in application
     */
    private static $_services = array();

    /**
     * {@inheritdoc}
     */
    public static function getServices()
    {
        return self::$_services;
    }

    /**
     * {@inheritdoc}
     */
    public static function setService(
        $name,
        $className,
        $resolver = null,
        $params = array(),
        $dependencies = array()
    ) {
        self::$_services[$name]              = array();
        self::$_services[$name]['className'] = $className;
        self::setParams($name, $params);
        self::setDependencies($name, $dependencies);
        self::setResolver($name, $resolver);
    }

    /**
     * {@inheritdoc}
     */
    public static function setParams($name, $params)
    {
        if (is_string($name) && is_array($params)) {
            if (!isset(self::$_services[$name]['parameters'])) {
                self::$_services[$name]['parameters'] = $params;
            } else {
                foreach ($params as $paramName => $value) {
                    self::$_services[$name]['parameters'][$paramName] = $value;
                }
            }
        } else {
            throw new ServiceException(
                500,
                "<strong>Internal server error:</strong> wrong parameter types for Service::setParams method"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function setDependencies($name, $dependencies)
    {
        if (is_string($name) && is_array($dependencies)) {
            self::$_services[$name]['dependencies'] = $dependencies;
        } else {
            throw new ServiceException(
                500,
                "<strong>Internal server error:</strong> wrong parameter types for Service::setDependencies method"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function setResolver($name, $resolve)
    {
        if (is_string($name) && is_callable($resolve)) {
            self::$_services[$name]['resolver'] = $resolve;
        } else {
            throw new ServiceException(
                500,
                "<strong>Internal server error:</strong> wrong parameter types for Service::setResolver method"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function hasResolver($name)
    {
        if (is_string($name)) {
            return isset(self::$_services[$name]['resolver']);
        } else {
            $parameterType = gettype($name);
            throw new ServiceException(
                500, "<strong>Internal server error:</strong> parameter for Service::hasResolver method must be 'string', '$parameterType' is given'"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function resolve($name)
    {
        if (self::hasResolver($name)) {
            $params = self::$_services[$name]['parameters'];

            if (!empty(self::$_services[$name]['dependencies'])) {
                $dependencies = self::$_services[$name]['dependencies'];
                foreach ($dependencies as $n => $className) {
                    $params[$n] = self::resolve($n);
                }
            }

            $resolver = self::$_services[$name]['resolver'];
            $service  = $resolver($params);

            return $service;
        }

        throw new ServiceException(
            500, "<strong>Internal server error:</strong> '$name' service has not been registered."
        );
    }
}