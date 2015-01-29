<?php
/**
 * File /framework/template/TemplateEngine.php contains TemplateEngine class
 * to make template rendering easier.
 *
 * PHP version 5
 *
 * @package Framework\Template
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Template;

use Framework\Exception\TemplateEngineException;

/**
 * Class TemplateEngine implements singleton design pattern
 * and is responsible for rendering views.
 *
 * Default implementation of {@link TemplateEngineInterface}.
 *
 * @package Framework\Template
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class TemplateEngine implements TemplateEngineInterface
{
    /**
     * @static
     * @var \Framework\Template\TemplateEngine|null TemplateEngine instance
     */
    private static $_instance = null;

    /**
     * @var array $_data Holds all data to be used in view
     */
    private $_data = array();

    /**
     * Method to clone objects of its class.
     *
     * @return object TemplateEngine.
     */
    private function __clone()
    {
    }

    /**
     * Method returns TemplateEngine instance creating it if it's not been instantiated before
     * otherwise existed TemplateEngine object will be returned.
     *
     * @return object TemplateEngine.
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
    public function getData()
    {
        return $this->_data;
    }

    /**
     * {@inheritdoc}
     */
    public function setData($name, $value)
    {
        if (is_string($name)) {
            $this->_data[$name] = $value;
        } else {
            $parameterType = gettype($name);
            throw new TemplateEngineException(
                500, "<strong>Internal server error:</strong> first parameter for TemplateEngine::setData method must be 'string', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeData($key)
    {
        unset($this->_data[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function __get($key)
    {
        if (isset($this->_data[$key])) {
            return $this->_data[$key];
        } else {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function render($layout, $view)
    {
        ob_start();
        require_once($view);
        $this->setData('view', ob_get_clean());
        require_once($layout);
    }
}