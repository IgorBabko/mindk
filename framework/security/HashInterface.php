<?php
/**
 * File /framework/security/HashInterface.php contains HashInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\security
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Security;

use Framework\Exception\HashException;

/**
 * Interface HashInterface is used to be implemented by Hash class.
 *
 * @api
 *
 * @package Framework\security
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface HashInterface
{
    /**
     * Method to hash password using 'sha256' with salt.
     *
     * @param  string $value Password to hash.
     * @param  string $salt Salt for password.
     *
     * @throws HashException HashException instance.
     *
     * @return string Hashed password.
     */
    public static function generatePass($value, $salt);

    /**
     * Method to generate salt with specified length.
     *
     * @param  int $length Length of salt.
     *
     * @throws HashException HashException instance.
     *
     * @return string Generated salt.
     */
    public static function generateSalt($length);
}