<?php
/**
 * File /framework/security/CsrfToken.php contains CsrfToken class
 * to prevent CSRF attacks.
 *
 * @package Framework\security
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Security;

use Framework\Config\Config;
use Framework\Exception\CsrfTokenException;
use Framework\Session\Session;

/**
 * Class CsrfToken is used to prevent CSRF attacks.
 * Default implementation of {@link CsrfTokenInterface}.
 *
 * @package Framework\security
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class CsrfToken implements CsrfTokenInterface
{
    /**
     * {@inheritdoc}
     */
    public static function generate()
    {
        $tokenName = Config::getSetting('session/token_name');
        $session = Session::getInstance();
        return $session->add($tokenName, md5(uniqid()));
    }

    /**
     * {@inheritdoc}
     */
    public static function check($token)
    {
        if (is_string($token)) {
            $tokenName = Config::getSetting('session/token_name');
            $session = Session::getInstance();
            if ($session->exists($tokenName) && $token === $session->get($tokenName)) {
                $session->remove($tokenName);
                return true;
            } else {
                return false;
            }
        } else {
            $parameterType = gettype($token);
            throw new CsrfTokenException(
                500, "<strong>Internal server error:</strong> parameter for CsrfToken::check method must be 'string', '$parameterType' is given"
            );
        }
    }
}