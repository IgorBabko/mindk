<?php
/**
 * File /framework/config/ConfigInterface.php contains ConfigInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Config
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Config;

/**
 * Interface ConfigInterface is used to be implemented by Config class.
 *
 * @api
 *
 * @package Framework\Config
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface ConfigInterface
{
    /**
     * Method to set app configurations.
     *
     * @param  string $configPath Path to config file.
     *
     * @throws \Framework\Exception\ConfigException ConfigException instance.
     *
     * @return void.
     */
    public static function setConfig($configPath);

    /**
     * Method to get app configurations.
     *
     * @throws \Framework\Exception\ConfigException ConfigException instance.
     *
     * @return array App configurations.
     */
    public static function getConfig();

    /**
     * Method to get particular app setting.
     *
     * @param  string $path Path to particular setting.
     *
     * @throws \Framework\Exception\ConfigException ConfigException instance.
     *
     * @return mixed Particular app setting.
     */
    public static function getSetting($path);
}