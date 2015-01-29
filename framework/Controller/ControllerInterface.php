<?php
/**
 * File /framework/controller/ControllerInterface.php contains ControllerInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\controllers
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Controller;

use Framework\Exception\ControllerException;
use Framework\Request\Request;
use Framework\Response\JsonResponse;
use Framework\Response\Response;
use Framework\Response\ResponseRedirect;
use Framework\Routing\Router;
use Framework\Template\TemplateEngine;

/**
 * Interface ControllerInterface is used to be implemented by controllers class.
 *
 * @api
 *
 * @package Framework\controllers
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface ControllerInterface
{
    /**
     * Method to get Request object.
     *
     * @return object|null Request.
     */
    public function getRequest();

    /**
     * Method to set Request object.
     *
     * @param  Request $request Request object.
     *
     * @throws ControllerException ControllerException instance.
     *
     * @return object Controller instance.
     */
    public function setRequest($request);

    /**
     * Method to get Response object.
     *
     * @return object|null Response.
     */
    public function getResponse();

    /**
     * Method to set Response object.
     *
     * @param  Response $response Response object.
     *
     * @throws ControllerException ControllerException instance.
     *
     * @return object Controller instance.
     */
    public function setResponse($response);

    /**
     * Method to get Router object.
     *
     * @return object|null Router.
     */
    public function getRouter();

    /**
     * Method to set Router object.
     *
     * @param  Router $router Router object.
     *
     * @throws ControllerException ControllerException instance.
     *
     * @return object Controller instance.
     */
    public function setRouter($router);

    /**
     * Method to get TemplateEngine object.
     *
     * @return object|null TemplateEngine.
     */
    public function getTemplateEngine();

    /**
     * Method to set TemplateEngine object.
     *
     * @param  TemplateEngine $templateEngine TemplateEngine object.
     *
     * @throws ControllerException ControllerException instance.
     *
     * @return object Controller instance.
     */
    public function setTemplateEngine($templateEngine);

    /**
     * Method to get JsonResponse object.
     *
     * @return object|null JsonResponse.
     */
    public function getJsonResponse();

    /**
     * Method to set JsonResponse object.
     *
     * @param  JsonResponse $jsonResponse JsonResponse object.
     *
     * @throws ControllerException ControllerException instance.
     *
     * @return object Controller instance.
     */
    public function setJsonResponse($jsonResponse);

    /**
     * Method to get ResponseRedirect object.
     *
     * @return object|null ResponseRedirect.
     */
    public function getResponseRedirect();

    /**
     * Method to set ResponseRedirect object.
     *
     * @param  ResponseRedirect $responseRedirect ResponseRedirect object.
     *
     * @throws ControllerException ControllerException instance.
     *
     * @return object Controller instance.
     */
    public function setResponseRedirect($responseRedirect);
}