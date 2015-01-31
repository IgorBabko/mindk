<?php
/**
 * File /framework/loader/LoaderException.php contains the Loader class
 * which handles automatic loading process.
 *
 * PHP version 5
 *
 * @package Framework\Loader
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Loader;

use Framework\Exception\LoaderException;

/**
 * Class Loader is to automatically load needed classes.
 * Default implementation of {@link LoaderInterface}.
 *
 * Class represents logic of automatic loading of classes without
 * require or include instructions.
 *
 * @package Framework\Loader
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Loader implements LoaderInterface
{
    /**
     * @static
     * @var Loader|null $_instance Loader instance
     */
    private static $_instance = null;

    /**
     * @static
     * @var array $_prefixes Namespace prefixes
     */
    private static $_prefixes = array();

    /**
     * Loader constructor.
     *
     * @return object Loader.
     */
    private function __construct()
    {
    }

    /**
     * Method to clone objects of its class.
     *
     * @return object Loader.
     */
    private function __clone()
    {
    }

    /**
     * Method returns Loader instance creating it if it's not been instantiated before
     * otherwise existed Loader object will be returned.
     *
     * @return object Loader.
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * {@inheritdoc}
     */
    public static function getPrefixes()
    {
        return self::$_prefixes;
    }

    /**
     * {@inheritdoc}
     */
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'loadClass'));
    }

    /**
     * {@inheritdoc}
     */
    public static function addNamespacePath($prefix, $base_dir, $prepend = false)
    {
        $prefix = trim($prefix, '\\') . '\\';
        $base_dir = rtrim($base_dir, '/') . DIRECTORY_SEPARATOR;
        $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';
        if (isset(self::$_prefixes[$prefix]) === false) {
            self::$_prefixes[$prefix] = array();
        }
        if ($prepend) {
            array_unshift(self::$_prefixes[$prefix], $base_dir);
        } else {
            array_push(self::$_prefixes[$prefix], $base_dir);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function loadClass($class)
    {
        $prefix = $class;
        while (false !== $pos = strrpos($prefix, '\\')) {
            $prefix = substr($class, 0, $pos + 1);
            $relative_class = substr($class, $pos + 1);
            $mapped_file = self::loadMappedFile($prefix, $relative_class);
            if ($mapped_file) {
                return $mapped_file;
            }
            $prefix = rtrim($prefix, '\\');
        }

        throw new LoaderException(500, "<strong>Internal server error:</strong> class '$class' not found");
    }

    /**
     * {@inheritdoc}
     */
    public static function loadMappedFile($prefix, $relative_class)
    {
        if (isset(self::$_prefixes[$prefix]) === false) {
            throw new LoaderException(
                500, "<strong>Internal server error:</strong> namespace prefix '$prefix' does not exist"
            );
        }
        foreach (self::$_prefixes[$prefix] as $base_dir) {
            $file = $base_dir . str_replace('\\', DIRECTORY_SEPARATOR, $relative_class) . '.php';
            //$file = $base_dir.str_replace('\\', '/', $relative_class).'.php';
            if (self::requireFile($file)) {
                return $file;
            }
        }

        throw new LoaderException(500, "<strong>Internal server error:</strong> can't load file");
    }

    /**
     * {@inheritdoc}
     */
    public static function requireFile($file)
    {
        if (file_exists($file)) {
            require_once($file);
            return true;
        } else {
            throw new LoaderException(500, "<strong>Internal server error:</strong> file '$file' does not exist");
        }
    }
}