<?php

namespace Framework;

class Loader {

	private static $_namespacePath = array();

	public static function addNamespacePath($namespace, $namespacePath) {
		self::$_namespacePath[$namespace] = $namespacePath;
	}

	public static function controller($controllerName, $params = null) {
		
		$controllerName .= 'Controller';
		$controllerFile = self::$_namespacePath['Blog\\Controller\\'] . $controllerName . '.php';
		
		if(file_exists($controllerFile)) {
			require_once $controllerFile;
		}

		$className = 'Blog\\Controller\\' . $controllerName;
		return new $className();
	}

	public static function model($modelName, $params = null) {
		
		$modelFile = self::$_namespacePath['Blog\\Model\\'] . $modelName . '.php';

		if(file_exists($modelFile)) {
			require_once $modelFile;
		}


		$className = 'Blog\\Model\\' . $modelName;
		return new $className();
	}

	public static function core($coreClassName, $params = null) {
		
		$coreClassFile = self::$_namespacePath["Framework\\"] . $coreClassName . '.php';

		if(file_exists($coreClassFile)) {
			require_once $coreClassFile;
		}

		$className = "Framework\\" . $coreClassName;
		if (isset($params)) {
			return new $className($params);
		} else {
			return new $className();
		}
	}
}