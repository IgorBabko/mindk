<?php
/**
 * /framework/autoloader.php contains the Autoloader class
 */

namespace Framework;

/**
 * Class Autoloader is to automatically autoload needed classes.
 *
 * Class represents logic of automatic loading of classes without
 * require or include instructions.
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Autoloader
{
    /**
     * @static
     * @var array $prefixes Prefixes of namespaces
     */
    public static $prefixes = array();

    /**
     * Method to register function which loads classes
     *
     * @static
     * @return void
     */
    public static function register()
    {
        spl_autoload_register('self::loadClass');
    }

    /**
     * Method to register namespaces.
     *
     * @static
     *
     * @param string $prefix prefix of namespace
     * @param string $base_dir base_dir
     * @param bool   $prepend whether to append loading function at the end or at the beginning of autoloading stack
     *
     * @return void
     */
    public static function addNamespacePath($prefix, $base_dir, $prepend = false)
    {
        $prefix   = trim($prefix, '\\').'\\';
        $base_dir = rtrim($base_dir, '/').DIRECTORY_SEPARATOR;
        $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR).'/';
        if (isset(self::$prefixes[$prefix]) === false) {
            self::$prefixes[$prefix] = array();
        }
        if ($prepend) {
            array_unshift(self::$prefixes[$prefix], $base_dir);
        } else {
            array_push(self::$prefixes[$prefix], $base_dir);
        }
    }

    /**
     * Method to load class automatically.
     *
     * Method loads needed class specified in parameter $class.
     *
     * @param mixed $class class to load
     *
     * @return bool|string path to the class file or false when loading fails
     */
    public static function loadClass($class)
    {
        $prefix = $class;
        while (false !== $pos = strrpos($prefix, '\\')) {
            $prefix         = substr($class, 0, $pos + 1);
            $relative_class = substr($class, $pos + 1);
            $mapped_file    = self::loadMappedFile($prefix, $relative_class);
            if ($mapped_file) {
                return $mapped_file;
            }
            $prefix = rtrim($prefix, '\\');
        }
        return false;
    }

    /**
     *
     * @param $prefix
     * @param $relative_class
     *
     * @return bool|string
     */
    public static function loadMappedFile($prefix, $relative_class)
    {
        if (isset(self::$prefixes[$prefix]) === false) {
            return false;
        }
        foreach (self::$prefixes[$prefix] as $base_dir) {
            $file = $base_dir.str_replace('\\', DIRECTORY_SEPARATOR, $relative_class).'.php';
            $file = $base_dir.str_replace('\\', '/', $relative_class).'.php';
            if (self::requireFile($file)) {
                return $file;
            }
        }
        return false;
    }

    /**
     * Method to require needed file.
     *
     * @param string $file filepath to require
     *
     * @return bool whether file required successfully or not
     */
    public static function requireFile($file)
    {
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
        return false;
    }
}