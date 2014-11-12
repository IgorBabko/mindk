<?php

namespace Framework;

class DI {

	public static $services = array();

	public static function setService($name, $className, $resolver = null, $params = array(), 
								$dependencies = array(), $isSingleton = false) {
		
		self::$services[$name] = array();
		self::$services[$name]['className'] = $className;
		self::$services[$name]['isSingleton'] = $isSingleton;
		self::setParams($name, $params);
		self::setDependencies($name, $dependencies);
		self::setResolver($name, $resolver);
	}

	public static function setParams($name, $params) {
		
		if(isset(self::$services[$name]['instance'])) {
			return;
		} elseif(!isset(self::$services[$name]['parameters'])) {
			self::$services[$name]['parameters'] = $params;
		} else {
			foreach($params as $paramName => $value) {
				self::$services[$name]['parameters'][$paramName] = $value;
			}
		}
	}

	public static function setDependencies($name, $dependencies) {
		self::$services[$name]['dependencies'] = $dependencies;
	}

	public static function setResolver($name, $resolve) {
		self::$services[$name]['resolver'] = $resolve;
	}

	public static function hasResolver($name) {
		return isset(self::$services[$name]['resolver']);
	}

	public static function resolveAsSingleton($name) {

	}

	public static function resolve($name)	{

		if(isset(self::$services[$name]['instance'])) {
			return self::$services[$name]['instance'];
		}

		if(self::hasResolver($name)) {
			$params = self::$services[$name]['parameters'];

			if(!empty(self::$services[$name]['dependencies'])) {
				$dependencies = self::$services[$name]['dependencies'];
				foreach($dependencies as $n => $className) {
					$params[$n] = self::resolve($n);
					if(self::$services[$n]['isSingleton'] && !isset(self::$services[$n]['instance'])) {
						self::$services[$n]['instance'] = $params[$n];
					}
				}
			}

			$resolver = self::$services[$name]['resolver'];
			$service = $resolver($params);
			if(self::$services[$name]['isSingleton']) {
				self::$services[$name]['instance'] = $service;
			}

			return $service;
		}
		echo 'error';
		//throw new Exception('Nothing registered with that name, fool.');
	}
}