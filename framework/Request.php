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

namespace Framework;

class Request {
    
    public $cookie;
    public $session;
    public $uri;
    public $method;
    public $headers = array();

    public function __construct($session = null, $cookie = null)
    {
        $this->headers = apache_request_headers();
        $this->method  = $_SERVER['REQUEST_METHOD'];
        $this->url     = $_SERVER['REQUEST_URI'];
        $this->session = $session;
        $this->cookie  = $cookie;
    }

    public function getURI()
    {
        return $this->uri;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getHeader($name) {
        return isset($headers[$name]) ? $headers[$name] : null;
    }

    public function getRequestMethod()
    {
        return $this->method;
    }

    public function getCookie($name)
    {
        return $this->cookie->get($name);
    }

    public function getSessionVar($name)
    {
        return $this->session->get($name);
    }

    public function getEnv($name)
    {
        return isset($_ENV[$name])?$_ENV[$name];
        null;
    }

    public function get($name, $filters = 0, $defaultValue = 0) {
        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : null;
    }

    public function getPost($name) {
        return isset($_POST[$name]) ? $_POST[$name] : null;
    }

    public function getQuery($name) {
        return isset($_GET[$name]) ? $_GET[$name] : null;
    }

    public function getServer() {
        return isset($_SERVER[$name]) ? $_SERVER[$name] : null;
    }

    public function has($name) {
        return isset($_REQUEST[$name]);
    }

    public function hasPost($name) {
        return isset($_POST[$name]);
    }

    public function hasQuery($name) {
        return isset($_GET[$name]);
    }

    public function hasServer($name) {
        return isset($_SERVER[$name]);
    }

    public function getHeader($name) {
        if (isset($this->headers[$name])) {
            return $this->headers[$name];
        }

        // throw ...
    }

    public function getScheme() {
        $scheme = parse_url($_SERVER['REQUEST_URI'])['scheme'];
        return $scheme;
    }

    public function isAjax() {
        return $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    }

    public function getRawBody() {}

    public function getServerAddress() {
        return $_SERVER['SERVER_ADDR'];
    }

    public function getServerName() {
        return gethostname();
    }

    public function getHttpHost() {
        $parsed_url = parse_url($_SERVER('REQUEST_URI'));
        return $parsed_url['scheme'] . $parsed_url['host'] . $parsed_url['port'];
    }

    public function getClientAddress() {
        return $_SERVER['REMOTE_ADDR'];
    }

    public function getUserAgent() {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public function isMethod($name) {
        return $_SERVER['REQUEST_METHOD'] === strtoupper($name);
    }

    public function hasFiles() {

    }

    public function getUploadedFiles() {

    }
}