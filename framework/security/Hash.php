<?php
/**
 * File /framework/security/Hash.php contains Hash class.
 *
 * PHP version 5
 *
 * @package Framework\security
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Security;

use Framework\Exception\HashException;

/**
 * Class Hash is helper to hash passwords.
 * Default implementation of {@link HashInterface}.
 *
 * @package Framework\security
 * @author  Igor Babko <i.i.bakbo@gmail.com>
 */
class Hash implements HashInterface
{
    /**
     * Method to hash password using 'sha256' with salt.
     *
     * @param  string $value Password to hash.
     * @param  string $salt  Salt for password.
     *
     * @throws HashException HashException instance.
     *
     * @return string Hashed password.
     */
    public static function generatePass($value, $salt = '')
    {
        if (is_string($value) && is_string($salt)) {
            return hash('sha256', $value.$salt);
        } else {
            throw new HashException("001", "Both parameters for Hash::generatePass method must be 'string'");
        }
    }

    /**
     * Method to generate salt with specified length.
     *
     * @param  int $length Length of salt.
     *
     * @throws HashException HashException instance.
     *
     * @return string Generated salt.
     */
    public static function generateSalt($length)
    {
        if (is_int($length)) {
            $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
            $numChars = strlen($chars);
            $string = '';
            for ($i = 0; $i < $length; $i++) {
                $string .= substr($chars, rand(1, $numChars) - 1, 1);
            }
            return $string;
        } else {
            $parameterType = gettype($length);
            throw new HashException("002", "Parameter for Hash::generateSalt method must be 'int', '$parameterType' is given");
        }
    }
}