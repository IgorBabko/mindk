<?php
/**
 * File /framework/security/XssDefenderInterface.php contains XssDefenderInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\security
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Security;

/**
 * Interface XssDefenderInterface is used to be implemented by XssDefender class.
 *
 * @api
 *
 * @package Framework\security
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface XssDefenderInterface
{
    /**
     * Method to get special characters and its html entities.
     *
     * @return array Special characters and its html entities.
     */
    public static function getSpecialCharacters();

    /**
     * Method to set special characters and its html entities.
     *
     * @param  array $specialCharacters Special characters and its html entities.
     *
     * @throws \Framework\Exception\XssDefenderException XssDefenderException instance.
     *
     * @return void
     */
    public static function setSpecialCharacters($specialCharacters);

    /**
     * Method to clean input using 'html' context.
     *
     * @param  string $input Insecure input.
     *
     * @return string Secure string for html context.
     */
    public static function cleanHtml($input);

    /**
     * Method to clean input using 'script' context.
     *
     * @param  string $input Insecure input.
     *
     * @return string Secure string for 'script' context.
     */
    public static function cleanScript($input);

    /**
     * Method to clean input using 'attribute' context.
     *
     * @param  string $input Insecure input.
     *
     * @return string Secure string for 'attribute' context.
     */
    public static function cleanAttribute($input);

    /**
     * Method to clean input using 'style' context.
     *
     * @param  string $input Insecure input.
     *
     * @return string Secure string for 'style' context.
     */
    public static function cleanStyle($input);

    /**
     * Method to clean input using 'url' context.
     *
     * @param  string $input Insecure input.
     *
     * @return string Secure string for 'url' context.
     */
    public static function cleanUrl($input);
}