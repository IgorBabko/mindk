<?php
/**
 * File /Framework/LoaderException.php contains the Loader class
 * which handles automatic loading process.
 *
 * PHP version 5
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

use Framework\Exception\LoaderException;

/**
 * Class Loader is to automatically load needed classes.
 *
 * Class represents logic of automatic loading of classes without
 * require or include instructions.
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Loader
{
    /**
     * @static
     * @var array $prefixes Prefixes of namespaces
     */
    public static $prefixes = array();

    /**
     * Method to register function which loads classes.
     *
     * @static
     * @return void
     */
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'loadClass'));
    }

    /**
     * Method to register namespaces and its associated directories.
     * If $prepend is set to true $base_dir (where classes from current namespace is situated)
     * will be set as first element of Namespace prefixes array otherwise $base_dir pushes
     * to the end of this array.
     *
     * @static
     *
     * @param string $prefix prefix of namespace.
     * @param string $base_dir base_dir.
     * @param bool   $prepend whether to append loading function at the end or at the beginning of autoloading stack.
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
     * Method to load classes automatically.
     *
     * Method loads needed class specified in $class parameter. It parses given classname
     * taking namespace prefix to $prefix variable and classname itself to $relative_class variable.
     * Then self::loadMappedFile loads class and method returns path to the file of loaded class.
     *
     * @param mixed $class class to load.
     *
     * @throws LoaderException LoaderException instance.
     *
     * @return bool|string path to the loaded file or false if loading fails.
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

        throw new LoaderException("Not Found");
    }

    /**
     * Method loads $relative_class iterating through all paths related to prefix $prefix.
     * Once classfile is detected in one of paths this path is required by self::requireFile.
     *
     * @param string $prefix         Namespace prefix.
     * @param string $relative_class Classname to load.
     *
     * @return bool|string Path to the loaded file or false if loading fails.
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
     * @param string $file filepath to require.
     *
     * @return bool whether file required successfully or not.
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