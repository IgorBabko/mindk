<?php
/**
 * File /framework/response/ResponseRedirectInterface.php contains ResponseRedirectInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Response
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Response;

/**
 * Interface ResponseRedirectInterface is used to be implemented by ResponseRedirect class.
 *
 * @api
 *
 * @package Framework\Response
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface ResponseRedirectInterface
{
    /**
     * Method to redirect to home page.
     *
     * @param  bool $permanent Whether redirect permanently or not?
     *
     * @return void
     */
    public function home($permanent);

    /**
     * Method to go back to previous page.
     *
     * @param  bool $permanent Whether redirect permanently or not?
     *
     * @return void
     */
    public function back($permanent);

    /**
     * Method to redirect using route name defined in routes of application.
     *
     * @param string $routeName Route name defined in routes of application.
     * @param bool   $permanent Whether redirect permanently or not?
     *
     * @throws \Framework\Exception\ResponseRedirectException ResponseRedirectException instance.
     *
     * @return void
     */
    public function route($routeName, $permanent);

    /**
     * Method to redirect using URL.
     *
     * @param string $url       URL to redirect to.
     * @param bool   $permanent Whether redirect permanently or not?
     *
     * @throws \Framework\Exception\ResponseRedirectException ResponseRedirectException instance.
     *
     * @return void
     */
    public function to($url, $permanent);
}