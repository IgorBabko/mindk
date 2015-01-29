<?php
/**
 * File /framework/response/JsonResponse.php contains JsonResponse class
 * to send response in json form.
 *
 * PHP version 5
 *
 * @package Framework\Response
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Response;

use Framework\Util\JsonParser;
use Framework\Exception\JsonResponseException;

/**
 * Class JsonResponse is used to send response in json form.
 * Default implementation of {@link JsonResponseInterface}.
 *
 * @package Framework\Response
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class JsonResponse implements JsonResponseInterface
{
    /**
     * @static
     * @var JsonResponse|null $_instance JsonResponse instance
     */
    private static $_instance = null;

    /**
     * JsonResponse constructor.
     *
     * @return object JsonResponse.
     */
    private function __construct()
    {
    }

    /**
     * Method to clone objects of its class.
     *
     * @return object JsonResponse.
     */
    private function __clone()
    {
    }

    /**
     * Method returns JsonResponse instance creating it if it's not been instantiated before
     * otherwise existed JsonResponse object will be returned.
     *
     * @return object JsonResponse.
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * {@inheritdoc}
     */
    public function send($value)
    {
        if (!headers_sent()) {
            header('Content-Type: application/json');
            $jsonString = JsonParser::encode($value);
            echo $jsonString;
        } else {
            throw new JsonResponseException(
                500,
                "<strong>Internal server error:</strong> HTTP headers has been sent already"
            );
        }
    }
}