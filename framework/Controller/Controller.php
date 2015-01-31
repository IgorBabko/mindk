<?php
/**
 * File /framework/controller/Controller.php contains Controller superclass
 * which will be inherited by all controllers.
 *
 * PHP version 5
 *
 * @package Framework\Controller
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Controller;

use Framework\DI\Service;
use Framework\Exception\ControllerException;
use Framework\Request\Request;
use Framework\Response\JsonResponse;
use Framework\Response\Response;
use Framework\Response\ResponseRedirect;
use Framework\Routing\Router;
use Framework\Template\TemplateEngine;

/**
 * Class Controller is superclass for all controllers.
 * Default implementation of {@link ControllerInterface}.
 *
 * Class holds all necessary fields and method for all controllers.
 *
 * @package Framework\Controller
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
abstract class Controller implements ControllerInterface
{
    /**
     * @var Request $_request Request object that represents http request
     */
    protected $_request;

    /**
     * @var Response $_response Response object that represents http response
     */
    protected $_response;

    /**
     * @var TemplateEngine $_templateEngine TemplateEngine object to render views
     */
    protected $_templateEngine;

    /**
     * @var Router $_router App router.
     */
    protected $_router;

    /**
     * Controller constructor injects all needed dependencies.
     *
     * @param  Router $router Router           object.
     * @param  Request $request Request          object.
     * @param  Response $response Response         object.
     * @param  TemplateEngine $templateEngine TemplateEngine   object.
     * @param  JsonResponse $jsonResponse JsonResponse     object.
     * @param  ResponseRedirect $responseRedirect ResponseRedirect object.
     *
     * @throws \Framework\Exception\ServiceException ServiceException instance.
     *
     * @return object Controller instance.
     */
    public function __construct(
        Router $router = null,
        Request $request = null,
        Response $response = null,
        TemplateEngine $templateEngine = null,
        JsonResponse $jsonResponse = null,
        ResponseRedirect $responseRedirect = null
    )
    {
        $this->_router = Service::resolve('router');
        $this->_request = Service::resolve('request');
        $this->_response = Service::resolve('response');
        $this->_templateEngine = Service::resolve('templateEngine');
        $this->_jsonResponse = Service::resolve('jsonResponse');
        $this->_responseRedirect = Service::resolve('responseRedirect');
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * {@inheritdoc}
     */
    public function setRequest($request)
    {
        if (is_object($request)) {
            $this->_request = $request;
            return $this;
        } else {
            $parameterType = gettype($request);
            throw new ControllerException(
                500, "<strong>Internal server error:</strong> parameter for Controller::setRequest method must be 'object', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * {@inheritdoc}
     */
    public function setResponse($response)
    {
        if (is_object($response)) {
            $this->_response = $response;
            return $this;
        } else {
            $parameterType = gettype($response);
            throw new ControllerException(
                500, "<strong>Internal server error:</strong> parameter for Controller::setResponse method must be 'object', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRouter()
    {
        return $this->_router;
    }

    /**
     * {@inheritdoc}
     */
    public function setRouter($router)
    {
        if (is_object($router)) {
            $this->_router = $router;
            return $this;
        } else {
            $parameterType = gettype($router);
            throw new ControllerException(
                500, "<strong>Internal server error:</strong> parameter for Controller::setRouter method must be 'object', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateEngine()
    {
        return $this->_templateEngine;
    }

    /**
     * {@inheritdoc}
     */
    public function setTemplateEngine($templateEngine)
    {
        if (is_object($templateEngine)) {
            $this->_templateEngine = $templateEngine;
            return $this;
        } else {
            $parameterType = gettype($templateEngine);
            throw new ControllerException(
                500, "<strong>Internal server error:</strong> parameter for Controller::setTemplateEngine method must be 'object', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getJsonResponse()
    {
        return $this->_jsonResponse;
    }

    /**
     * {@inheritdoc}
     */
    public function setJsonResponse($jsonResponse)
    {
        if (is_object($jsonResponse)) {
            $this->_jsonResponse = $jsonResponse;
            return $this;
        } else {
            $parameterType = gettype($jsonResponse);
            throw new ControllerException(
                500, "<strong>Internal server error:</strong> parameter for Controller::setJsonResponse method must be 'object', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseRedirect()
    {
        return $this->_responseRedirect;
    }

    /**
     * {@inheritdoc}
     */
    public function setResponseRedirect($responseRedirect)
    {
        if (is_object($responseRedirect)) {
            $this->_responseRedirect = $responseRedirect;
            return $this;
        } else {
            $parameterType = gettype($responseRedirect);
            throw new ControllerException(
                500, "<strong>Internal server error:</strong> parameter for Controller::setResponseRedirect method must be 'object', '$parameterType' is given"
            );
        }
    }
}