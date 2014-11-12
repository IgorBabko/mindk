<?php


class Session implements ArrayAccess
{
    private $meta = '__meta';
    private $started = false;

    public function __construct()
    {
        /*if (ini_get('session.auto_start')) {
            $this->start();
        }*/
    }

    public function isStarted() {
        return $this->started;
    }

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
     * write session data to store and close the session.
     */
    public function commit()
    {
        session_commit();
        $this->started = false;
    }

    public function destroy()
    {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    public function get($name, $default = NULL)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : $default;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return session_name();
    }

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
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset
     * @return boolean true on success or false on failure.
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        if($this->started === true) {
            return isset($_SESSION[$offset]);
        }

        // throw ...
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        if($this->started === true) {
            return $this->get($offset);
        }

        // throw ...
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if($this->started === true) {
            $_SESSION[$offset] = $value;
        }

        // throw ...
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        if($this->started === true) {
            unset($_SESSION[$offset]);
        }
        
        // throw ...
    }
}