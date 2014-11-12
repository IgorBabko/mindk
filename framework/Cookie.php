<?php

class Cookie {

	const SESSION = null;
	const ONE_DAY = 86400;
	const SEVEN_DAYS = 604800;
	const MONTH = 2592000;
	const SIX_MONTHS = 15811200;
	const ONE_YEAR = 31536000;
	const LIFETIME = -1;

	public $cookies = array();


	public function exists($name) {
		return isset($this->cookies[$name]);
	}

	public function sendCookie() {
		if (!headers_sent()) {
			foreach ($this->cookies as $cookieName => $cookieInfo) {
				$retval = setcookie($cookieName, $cookieInfo['value'], $cookieInfo['expiry'], $cookieInfo['path'], $cookieInfo['domain']);
				if($retval) {
					$_COOKIE[$cookieName] = $cookieInfo['value'];
				}
			}
		}

		// throw ...
	}


	public function set($name, $value, $expiry = self::ONE_YEAR, $path = '/', $domain = false) {

		if($expiry === -1) {
			$expiry = 1893456000;
		} elseif(is_numeric($expiry)) {
			$expiry += time();
		} else {
			$expiry = strtotime($expiry);
		}
		$this->cookies[$name] = array('value' => $value, 'expiry' => $expiry, 'path' => $path, 'domain' => $domain ? $_SERVER['HTTP_HOST'] : $domain);
	}

	public function getCookie() {
		return $this->cookies;
	}


	public function isEmpty($name) {

		if($this->exists($name))
			return empty($this->cookie[$name]);

		// throw ...
	}

	public function get($name, $default = '') {
		return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $default;
	}
/*
	public function set($name, $value, $expiry = self::ONE_YEAR, $path = '/', $domain = false) {
		$retval = false;
		if(!headers_sent()) {
			if($domain === false) {
				$domain = $_SERVER['HTTP_HOST'];
			}
			if($expiry === -1) {
				$expiry = 1893456000;
			} elseif(is_numeric($expiry)) {
				$expiry += time();
			} else {
				$expiry = strtotime($expiry);
			}

			$retval = setcookie($name, $value, $expiry, $path, $domain);
			if($retval) {
				$_COOKIE[$name] = $value;
			}
		}
	}*/

	public function remove($name, $path = '/', $domain = false, $remove_from_global = false) {
		$retval = false;
		if(!headers_sent()) {
			if($domain === false) {
				$domain = $_SERVER['HTTP_HOST'];
			}
			
			$retval = setcookie($name, '', time() - 3600, $path, $domain);

			if($remove_from_global) {
				unset($_COOKIE[$name]);
			}
		}
		return $retval;
	}
}