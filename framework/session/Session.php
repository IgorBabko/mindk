<?php
/**
 * File /Framework\Session.php contains Session class is used to easily manipulate
 * with session variables.
 *
 * PHP version 5
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

use Framework\Exception\SessionException;

/**
 * Class Session represents objects to work with sessions.
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Session
{
    /**
     * @var string $_meta Session variable that keeps general information of current session
     */
    private $_meta = '__meta';
    /**
     * @var bool $_started Is session started?
     */
    private $started = false;

    /**
     * Methods checks whether session is started or not.
     *
     * @return bool Is session started?
     */
    public function isStarted()
    {
        return $this->started;
    }

    /**
     * Method starts session. In a case it's already been started method do nothing but returns void.
     * Also it sets session variable __meta with general information of current session.
     *
     * @return void
     */
    public function start()
    {
        if ($this->started === true) {
            return;
        }

        session_start();
        if (!isset($_SESSION[$this->meta])) {
            $this->init();
        } else {
            $_SESSION[$this->meta]['activity'] = $_SERVER['REQUEST_TIME'];
        }

        $this->started = true;
    }

    /**
     * Method destroys session by setting up expired session cookie and remove all session variables.
     *
     * @return void
     */
    public function destroy()
    {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }

    /**
     * Method returns session name.
     *
     * @return string Session name.
     */
    public function getName()
    {
        return session_name();
    }

    /**
     * Method sets session variable with name __meta which holds
     * general information of current session.
     *
     * @return void
     */
    private function init()
    {
        $_SESSION[$this->meta] = array(
            'ip'       => $_SERVER['REMOTE_ADDR'],
            'name'     => session_name(),
            'created'  => $_SERVER['REQUEST_TIME'],
            'activity' => $_SERVER['REQUEST_TIME'],
        );
    }

    /**
     * Method checks if given session variable $name exists or not.
     *
     * @param string $name Name of session variable to be checked.
     *
     * @throws SessionException SessionException instance.
     *
     * @return bool Does session variable $name exist?
     */
    public function exists($name)
    {
        if ($this->started === true) {
            return isset($_SESSION[$name]);
        }

        throw new SessionException("Session isn't started.");
    }


    /**
     * Method gets value of session variable $name if exists.
     *
     * @param string $name Name of session variable value of to be returned.
     *
     * @throws SessionException SessionException instance.
     *
     * @return string|null Value of session variable $name or null.
     */
    public function get($name)
    {
        if ($this->started === true) {
            return $_SESSION[$name]?$_SESSION[$name]:null;
        }

        throw new SessionException("Session isn't started.");
    }


    /**
     * Method sets session variable $name with value $value.
     *
     * @param string $name  Name of session variable to be added.
     * @param string $value Value of session variable with name $name.
     *
     * @throws SessionException SessionException instance.
     *
     * @return void
     */
    public function add($name, $value)
    {
        if ($this->started === true) {
            $_SESSION[$name] = $value;
        }

        throw new SessionException("Session isn't started.");
    }

    /**
     * Method removes specified session variable.
     *
     * @param string $name Name of session variable to remove.
     *
     * @throws SessionException SessionException instance.
     *
     * @return void
     */
    public function remove($name)
    {
        if ($this->started === true) {
            unset($_SESSION[$name]);
        }

        throw new SessionException("Session isn't started.");
    }
}