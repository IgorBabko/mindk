<?php
/**
 * File /framework/config/Config.php contains Config class
 * to access app configurations.
 *
 * PHP version 5
 *
 * @package Framework\Config
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Config;

use Framework\Exception\ConfigException;

/**
 * Class Config is used to access app configurations.
 * Default implementation of {@link ConfigInterface}.
 *
 * Usage:
 *
 *     app configurations: array( 'setting1' => array('setting11' => value11),
 *                                'setting2' => value2,
 *                                'setting3' => array('setting31' => value31,
 *                                                    'setting32' => value32)
 *                              );
 *
 *     - Config::get('setting2') - get value of setting2;
 *     - Config::get('setting3/setting31') - get value of setting31;
 *     - Config::get('setting1/setting11') - get value of setting11.
 *
 * @package Framework\Config
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Config implements ConfigInterface
{
    /**
     * @var array $_config App configurations
     */
    private static $_config = null;

    /**
     * {@inheritdoc}
     */
    public static function setConfig($configPath = CONF)
    {
        if (!is_string($configPath)) {
            $parameterType = gettype($configPath);
            throw new ConfigException(
                500, "<strong>Internal server error:</strong> path to config file must be 'string', '$parameterType' is given'"
            );
        } elseif (!file_exists($configPath)) {
            throw new ConfigException(
                500, "<strong>Internal server error:</strong> config file '$configPath' doesn't exist"
            );
        } else {
            self::$_config = require_once($configPath);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getConfig()
    {
        if (isset(self::$_config)) {
            return self::$_config;
        } else {
            throw new ConfigException(500, "<strong>Internal server error:</strong> config is not set");
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSetting($path)
    {
        if (!is_string($path)) {
            $parameterType = gettype($path);
            throw new ConfigException(
                500, "<strong>Internal server error:</strong> config name must be 'string', '$parameterType' is given'"
            );
        }

        $path = explode('/', $path);
        $setting = &self::$_config;
        foreach ($path as $bit) {
            if (!isset($setting[$bit])) {
                throw new ConfigException(500, "<strong>Internal server error:</strong> setting '$bit' doesn't exist");
            } else {
                $setting = &$setting[$bit];
            }
        }
        return $setting;
    }
}