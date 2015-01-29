<?php
/**
 * File /framework/session/Session.php contains Session class to easily manipulate
 * with session variables.
 *
 * PHP version 5
 *
 * @package Framework\Session
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Session;

use Framework\Exception\SessionException;

/**
 * Class Session represents objects to work with sessions.
 * Default implementation of {@link SessionInterface}.
 *
 * @package Framework\Session
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Session implements SessionInterface
{
    /**
     * @static
     * @var Session|null $_instance Session instance
     */
    private static $_instance = null;

    /**
     * @var string $_meta Session variable that keeps general information of current session
     */
    private $_meta = '__meta';

    /**
     * @var bool $_started Is session started?
     */
    private $_started = false;

    /**
     * Session constructor.
     *
     * @return object Session.
     */
    private function __construct()
    {
    }

    /**
     * Method to clone objects of its class.
     *
     * @return object Session.
     */
    private function __clone()
    {
    }

    /**
     * Method returns Session instance creating it if it's not been instantiated before
     * otherwise existed Session object will be returned.
     *
     * @return object Session.
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted()
    {
        return $this->_started;
    }

    /**
     * {@inheritdoc}
     */
    public function start()
    {
        if ($this->_started === true) {
            return;
        }

        session_start();
        if (!isset($_SESSION[$this->_meta])) {
            $this->init();
        } else {
            $_SESSION[$this->_meta]['activity'] = $_SERVER['REQUEST_TIME'];
        }

        $this->_started = true;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getName()
    {
        return session_name();
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $_SESSION[$this->_meta] = array(
            'ip'       => $_SERVER['REMOTE_ADDR'],
            'name'     => session_name(),
            'created'  => $_SERVER['REQUEST_TIME'],
            'activity' => $_SERVER['REQUEST_TIME'],
        );
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
        if ($this->_started === true) {
            return isset($_SESSION[$name]);
        } else {
            throw new SessionException(500, "<strong>Internal server error:</strong> session isn't started.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        if ($this->_started === true) {
            return isset($_SESSION[$name])?$_SESSION[$name]:null;
        } else {
            throw new SessionException(500, "<strong>Internal server error:</strong> session isn't started.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add($name, $value)
    {
        if ($this->_started === true) {
            $_SESSION[$name] = $value;
            return $value;
        } else {
            throw new SessionException(500, "<strong>Internal server error:</strong> session isn't started.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove($name)
    {
        if ($this->_started !== true) {
            throw new SessionException(500, "<strong>Internal server error:</strong> session isn't started.");
        } else {
            unset($_SESSION[$name]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function flash($name, $value)
    {
        if (!is_string($value)) {
            $parameterType = gettype($value);
            throw new SessionException(
                500, "<strong>Internal server error:</strong> second parameter for Session::flash method must be 'string', '$parameterType' is given"
            );
        } else {
            $flashMsgs        = $this->exists('flashMsgs')?$this->get('flashMsgs'):array();
            $flashMsgs[$name] = $value;
            $this->add('flashMsgs', $flashMsgs);
        }
    }
}