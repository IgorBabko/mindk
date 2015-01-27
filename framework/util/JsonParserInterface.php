<?php
/**
 * File /framework/util/JsonParserInterface.php contains JsonParserInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Util
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Util;

/**
 * Interface JsonParserInterface is used to be implemented by JsonParser class.
 *
 * @api
 *
 * @package Framework\Util
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface JsonParserInterface
{
    /**
     * Method to get error descriptions.
     *
     * @return array Error descriptions.
     */
    public static function getErrorDescriptions();

    /**
     * Method to get options for JsonParser::encode and JsonParser::decode methods.
     *
     * @return array Array of options.
     */
    public static function getOptions();

    /**
     * Method for serialization values into json string (based on 'json_encode' function).
     *
     * @param  mixed $value   Value to serialize into json string.
     * @param  int   $options Options to define serialization behaviour.
     * @param  int   $depth   Maximum depth.
     *
     * @throws \Framework\Exception\JsonParserException JsonParserException instance.
     *
     * @return string Json string.
     */
    public static function encode($value, $options, $depth);

    /**
     * Method to parse json string into PHP value.
     *
     * @param  string $jsonString Json string.
     * @param  bool   $assoc      When true, returned objects will be converted into associative arrays.
     * @param  int    $depth      Recursion depth.
     * @param  int    $options    Decode options (self::$options['bigIntAsStr'] is only available).
     *
     * @throws \Framework\Exception\JsonParserException JsonParserException instance.
     *
     * @return mixed PHP value.
     */
    public static function decode($jsonString, $assoc, $depth, $options);
}