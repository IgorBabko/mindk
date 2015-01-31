<?php
/**
 * File /framework/loader/LoaderInterface.php contains LoaderInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Loader
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Loader;

/**
 * Interface LoaderInterface is used to be implemented by Loader class.
 *
 * @api
 *
 * @package Framework\Loader
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface LoaderInterface
{
    /**
     * Method to get namespace prefixes.
     *
     * @return array Namespace prefixes.
     */
    public static function getPrefixes();

    /**
     * Method to register function which loads classes.
     *
     * @return void
     */
    public static function register();

    /**
     * Method to register namespaces and its associated directories.
     * If $prepend is set to true $base_dir (where classes from current namespace is situated)
     * will be set as first element of Namespace prefixes array otherwise $base_dir pushes
     * to the end of this array.
     *
     * @param  string $prefix Prefix of namespace.
     * @param  string $base_dir Base_dir.
     * @param  bool $prepend Whether to append loading function at the end or at the beginning of auto loading stack.
     *
     * @return void
     */
    public static function addNamespacePath($prefix, $base_dir, $prepend);

    /**
     * Method to load classes automatically.
     *
     * Method loads needed class specified in $class parameter. It parses given class name
     * taking namespace prefix to $prefix variable and class name itself to $relative_class variable.
     * Then Loader::loadMappedFile loads class and method returns path to the file of loaded class.
     *
     * @param  mixed $class Class to load.
     *
     * @throws \Framework\Exception\LoaderException LoaderException instance.
     *
     * @return bool|string Path to the loaded file or false if loading fails.
     */
    public static function loadClass($class);

    /**
     * Method loads $relative_class iterating through all paths related to prefix $prefix.
     * Once class file is detected in one of paths this path is required by Loader::requireFile.
     *
     * @param  string $prefix Namespace prefix.
     * @param  string $relative_class Class name to load.
     *
     * @throws \Framework\Exception\LoaderException LoaderException instance.
     *
     * @return bool|string Path to the loaded file or false if loading fails.
     */
    public static function loadMappedFile($prefix, $relative_class);

    /**
     * Method to require needed file.
     *
     * @param  string $file File path to require.
     *
     * @throws \Framework\Exception\LoaderException LoaderException instance.
     *
     * @return bool True if file has been required successfully.
     */
    public static function requireFile($file);
}