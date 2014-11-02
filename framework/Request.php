<?php

/*

$GLOBALS 	Массив содержит ссылки на все переменные, объявленные в данном скрипте. Это ассоциативный массив, в котором имена переменных являются ключами.
$_SERVER 	Массив содержит все данные о настройках среды выполнения скрипта и параметры сервера.
$_GET 	Список переменных, переданных скрипту методом GET, т.е. через параметры URL-запроса.
$_POST 	Список переменных, переданных скрипту методом POST.
$_COOKIE 	Массив содержит все cookies, которые сервер установил на стороне пользователя.
$_FILES 	Содержит список файлов, загруженных на сервер из формы. Более детально мы рассмотрим этот массив в уроке, посвящённом загрузке файлов на сервер.
$_ENV 	Содержит переменные окружения, установленные для всех скриптов на сервере.
$_REQUEST 	Этот массив объединяет массивы $GET, $POST и $COOKIE. очень часто бывает удобен при обработке пользовательских запросов, но применять его для защищённой обработки данных не стоит.
$_SESSION 	Массив содержит все переменные сессии текущего пользователя.

*/

class Request {

	public $uri;
	public $method;

	public function __construct() {
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->url    = $_SERVER['REQUEST_URI'];
	}

	public function getURI() {
		return $this->uri;
	}
	
	public function getRequestMethod() {
		return $this->method;
	}

	public function getServerVar($name) {
		return isset($_SERVER[$name]) ? $_SERVER[$name] : null;
	}

	public function getCookie($name) {
		return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null; 
	}

	public function getSessionVar($name) {
		return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
	}

	public function getEnvVar($name) {
		return isset($_ENV[$name]) ? $_ENV[$name] ; null;
	}

	public function getVar($name) {
		if($this->method == 'GET') {
			return isset($_GET[$name])  ? $_GET[$name]  : null;
		} elseif($this->method == 'POST') {
			return isset($_POST[$name]) ? $_POST[$name] : null;
		} else {
			return null;
		}
	}
}