<?php

namespace Framework;

class Autoloader
{
    public $prefixes = array();

    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    public function addNamespacePath($prefix, $base_dir, $prepend = false)
    {
        $prefix   = trim($prefix, '\\').'\\';
        $base_dir = rtrim($base_dir, '/').DIRECTORY_SEPARATOR;
        $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR).'/';
        if (isset($this->prefixes[$prefix]) === false) {
            $this->prefixes[$prefix] = array();
        }
        if ($prepend) {
            array_unshift($this->prefixes[$prefix], $base_dir);
        } else {
            array_push($this->prefixes[$prefix], $base_dir);
        }
    }

    public function loadClass($class)
    {
        $prefix = $class;
        while (false !== $pos = strrpos($prefix, '\\')) {
            $prefix         = substr($class, 0, $pos + 1);
            $relative_class = substr($class, $pos + 1);
            $mapped_file    = $this->loadMappedFile($prefix, $relative_class);
            if ($mapped_file) {
                return $mapped_file;
            }
            $prefix = rtrim($prefix, '\\');
        }
        return false;
    }

    public function loadMappedFile($prefix, $relative_class)
    {
        if (isset($this->prefixes[$prefix]) === false) {
            return false;
        }
        foreach ($this->prefixes[$prefix] as $base_dir) {
            $file = $base_dir.str_replace('\\', DIRECTORY_SEPARATOR, $relative_class).'.php';
            $file = $base_dir.str_replace('\\', '/', $relative_class).'.php';
            if ($this->requireFile($file)) {
                return $file;
            }
        }
        return false;
    }

    public function requireFile($file)
    {
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
        return false;
    }
}