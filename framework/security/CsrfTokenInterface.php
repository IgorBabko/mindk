<?php
/**
 * File /framework/security/CsrfTokenInterface.php contains CsrfTokenInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\security
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Security;

/**
 * Interface CsrfTokenInterface is used to be implemented by CsrfToken class.
 *
 * @api
 *
 * @package Framework\security
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface CsrfTokenInterface
{
    /**
     * Method to generate secret token and put it in session variable 'token_name'.
     *
     * @return mixed Secret token.
     */
    public static function generate();

    /**
     * Method to check whether secret token exists and equal to SESSION['token_name'].
     *
     * @param  string $token Secret token to check.
     *
     * @throws \Framework\Exception\CsrfTokenException CsrfTokenException instance.
     *
     * @return bool True if secret token exists and equal to SESSION['token_name'].
     */
    public static function check($token);
}