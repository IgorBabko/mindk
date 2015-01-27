<?php
/**
 * File /framework/util/JsonParser.php contains JsonParser class which is helper to work with json format.
 *
 * PHP version 5
 *
 * @package Framework\Util
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Util;

use Framework\Exception\JsonParserException;

/**
 * Class JsonParser acts as wrapper for 'json_encode' and 'json_decode' functions.
 * Default implementation of {@link JsonParserInterface}.
 *
 * @package Framework\Util
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class JsonParser implements JsonParserInterface
{
    /**
     * @static
     * @var array $_errorDescriptions Error descriptions which might occur while serializing or parsing json
     */
    private static $_errorDescriptions = array(
        JSON_ERROR_NONE             => "No error has occurred",
        JSON_ERROR_DEPTH            => "The maximum stack depth has been exceeded",
        JSON_ERROR_STATE_MISMATCH   => "Incorrect JSON",
        JSON_ERROR_CTRL_CHAR        => "Control character error, possibly incorrectly encoded",
        JSON_ERROR_SYNTAX           => "Syntax error",
        JSON_ERROR_UTF8             => "Malformed UTF-8 characters, possibly incorrectly encoded",
        JSON_ERROR_RECURSION        => "The object or array passed to JSON::encode method include recursive references and cannot be encoded",
        JSON_ERROR_INF_OR_NAN       => "The value passed to JSON::encode method includes either NAN or INF",
        JSON_ERROR_UNSUPPORTED_TYPE => "A value of an unsupported type was given to JSON::encode method, such as a resource"
    );

    /**
     * @var array $_options Options for JsonParser::encode method,
     *                      'bigIntAsStr' option is also available for JsonParser::decode method
     *
     * Description (JsonParser::$_options[$key]):
     *     $key = 'hexTag'          ) all < and > are converted to \u003C and \u003E;
     *     $key = 'hexAmp'          ) all &s are converted to \u0026;
     *     $key = 'hexApos'         ) all ' are converted to \u0027;
     *     $key = 'hexQuot'         ) all " are converted to \u0022;
     *     $key = 'forceObj'        ) outputs an object rather than an array when a non-associative array is used;
     *     $key = 'numeric'         ) encodes numeric strings as numbers;
     *     $key = 'bigIntAsStr'     ) encodes large integers as their original string value;
     *     $key = 'prettyPrint'     ) use whitespace in returned data to format it;
     *     $key = 'unescapedSlashes') don't escape /;
     *     $key = 'unescapedUnicode') encode multibyte Unicode characters literally (default is to escape as \uXXXX).
     */
    private static $_options = array(
        'hexTag'           => JSON_HEX_TAG,
        'hexAmp'           => JSON_HEX_AMP,
        'hexApos'          => JSON_HEX_APOS,
        'hexQuot'          => JSON_HEX_QUOT,
        'forceObj'         => JSON_FORCE_OBJECT,
        'numeric'          => JSON_NUMERIC_CHECK,
        'bigIntAsStr'      => JSON_BIGINT_AS_STRING,
        'prettyPrint'      => JSON_PRETTY_PRINT,
        'unescapedSlashes' => JSON_UNESCAPED_SLASHES,
        'unescapedUnicode' => JSON_UNESCAPED_UNICODE
    );

    /**
     * {@inheritdoc}
     */
    public static function getErrorDescriptions()
    {
        return self::$_errorDescriptions;
    }

    /**
     * {@inheritdoc}
     */
    public static function getOptions()
    {
        return self::$_options;
    }

    /**
     * {@inheritdoc}
     */
    public static function encode($value, $options = 0, $depth = 512)
    {
        $jsonString = json_encode($value, $options, $depth);
        $errorCode  = json_last_error();

        if ($errorCode === 0) {
            return $jsonString;
        } else {
            throw new JsonParserException($errorCode, self::$_errorDescriptions[$errorCode]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function decode($jsonString, $assoc = false, $depth = 512, $options = 0)
    {
        $data      = json_decode($jsonString, $assoc, $depth, $options);
        $errorCode = json_last_error();

        if ($errorCode === 0) {
            return $data;
        } else {
            throw new JsonParserException($errorCode, self::$_errorDescriptions[$errorCode]);
        }
    }
}