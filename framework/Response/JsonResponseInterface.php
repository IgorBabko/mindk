<?php
/**
 * File /framework/response/JsonResponseInterface.php contains JsonResponseInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Response
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Response;

/**
 * Interface JsonResponseInterface is used to be implemented by JsonResponse class.
 *
 * @api
 *
 * @package Framework\Response
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface JsonResponseInterface
{
    /**
     * Method to send response in json form.
     *
     * @param  mixed $value Value to send.
     *
     * @throws \Framework\Exception\JsonResponseException JsonResponseException instance.
     *
     * @return void
     */
    public function send($value);
}