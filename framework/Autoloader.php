<?php

namespace Framework;

class Autoloader
{
    public static $prefixes = array();

    public static function register()
    {
        spl_autoload_register('self::loadClass');
    }

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

    public static function requireFile($file)
    {
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
        return false;
    }
}