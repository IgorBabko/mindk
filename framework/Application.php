<?php

namespace Framework;

#require_once(__DIR__.'/Loader.php');

#use \Framework\Controller\Controller;


class Application {

	private $_controller;
	//private $_action;
	private $_params;
	private $_config;
	private $_routes;

	public function __construct($info = null) {
		
		if ($info !== null) 
		{
			$this->_config = require_once $info['config'];
			$this->_routes = require_once $info['routes'];
		}
	}

	public function run() {

		//echo $_GET['uri'];
		if (isset($_GET['uri'])) 
		{

			$action = '';
			$params = array();
			//echo '$_GET exists' . '<br />';
			$uri = explode('/', $_GET['uri']);

			if (!empty($uri[0])) 
			{
				//echo 'controller exists' . '<br />';
				$this->controller = Loader::controller($uri[0]);
				
				if (isset($uri[1]) && method_exists(ucfirst($uri[0]) . 'Controller', $uri[1] . 'Action')) 
				{
					//echo 'method exists' . '<br />';
					$action = $uri[1] . 'Action';
					unset($uri[1]);

					if (isset($uri[2])) 
					{
						//echo 'params exist' . '<br />';
						$this->controller->$action($uri);
					} 
					else 
					{
						$this->controller->$action();
					}
				} else 
				{
					$action = 'indexAction';
					$this->controller->$action();
				}
				unset($uri[0]);
			} 
			else 
			{
				$this->controller = Loader::controller('hello');
				$action = 'indexAction';
				$this->controller->$action();
			}
		} 
		else 
		{
		// @TODO ...
		}
	}
}