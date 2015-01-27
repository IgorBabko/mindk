<?php
/**
 * File /framework/session/SessionInterface.php contains SessionInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Session
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Session;

use Framework\Exception\SessionException;

/**
 * Interface SessionInterface is used to be implemented by Session class.
 *
 * @api
 *
 * @package Framework\Session
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface SessionInterface
{
    /**
     * Methods checks whether session is started or not.
     *
     * @return bool Is session started?
     */
    public function isStarted();

    /**
     * Method starts session. In a case it's already been started method do nothing but returns void.
     * Also it sets session variable __meta with general information of current session.
     *
     * @return void
     */
    public function start();

    /**
     * Method destroys session by setting up expired session cookie and remove all session variables.
     *
     * @return void
     */
    public function destroy();

    /**
     * Method returns session name.
     *
     * @return string Session name.
     */
    public function getName();

    /**
     * Method sets session variable with name __meta which holds
     * general information of current session.
     *
     * @return void
     */
    public function init();

    /**
     * Method checks if given session variable $name exists or not.
     *
     * @param  string $name Name of session variable to be checked.
     *
     * @throws \Framework\Exception\SessionException SessionException instance.
     *
     * @return bool Does session variable $name exist?
     */
    public function exists($name);

    /**
     * Method gets value of session variable $name if exists.
     *
     * @param  string $name Name of session variable value of to be returned.
     *
     * @throws \Framework\Exception\SessionException SessionException instance.
     *
     * @return mixed Value of session variable $name or null.
     */
    public function get($name);

    /**
     * Method sets session variable $name with value $value.
     *
     * @param  string $name  Name of session variable to be added.
     * @param  string $value Value of session variable with name $name.
     *
     * @throws \Framework\Exception\SessionException SessionException instance.
     *
     * @return mixed Added value.
     */
    public function add($name, $value);

    /**
     * Method removes specified session variable.
     *
     * @param  string $name Name of session variable to remove.
     *
     * @throws \Framework\Exception\SessionException SessionException instance.
     *
     * @return void
     */
    public function remove($name);

    /**
     * Method to add flash message to $_SESSION['flashMsgs'] array.
     * Note: flash message is message that exists until next redirection.
     *
     * @param  string $name  Name of flash message.
     * @param  string $value Flash message.
     *
     * @throws SessionException SessionException instance.
     *
     * @return void
     */
    public function flash($name, $value);
}