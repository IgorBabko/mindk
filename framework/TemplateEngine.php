<?php
/**
 * File /Framework/TemplateEngine.php contains TemplateEngine class
 * to make template rendering easier.
 *
 * PHP version 5
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

/**
 * Class TemplateEngine implements singleton design pattern
 * and is responsible for rendering views.
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class TemplateEngine
{
    /**
     * @var \Framework\TemplateEngine|null TemplateEngine instance.
     */
    protected static $_instance = null;
    /**
     * @var string $_templateDir Default template directory
     */
    public $_templateDir;
    /**
     * @var array $_data Holds all data to be used in view
     */
    public $_data = array();

    /**
     * TemplateEngine constructor.
     *
     * Constructor sets default template directory
     * to TemplateEngine::_templateDir.
     *
     * @param string $templateDir Default template directory.
     */
    private function __construct($templateDir)
    {
        $this->_templateDir = $templateDir;
    }


    /**
     * Method to clone objects of its class.
     *
     * @return \Framework\TemplateEngine TemplateEngine instance.
     */
    private function __clone()
    {
    }

    /**
     * Method returns TemplateEngine instance creating it if it's not been instantiated before
     * otherwise existed TemplateEngine will be returned.
     *
     * @param string $templateDir Path to the views directory.
     *
     * @return \Framework\TemplateEngine TemplateEngine instance.
     */
    public static function getInstance($templateDir)
    {
        if (null === self::$_instance) {
            self::$_instance = new self($templateDir);
        }
        return self::$_instance;
    }

    /**
     * Method sets data to be used in view.
     *
     * @param string $name  Data name;
     * @param mixed  $value Data itself.
     *
     * @return void
     */
    public function setData($name, $value)
    {
        $this->_data[$name] = $value;
    }

    /**
     * Method removes data with name $name from
     * TemplateEngine::_data array.
     *
     * @param string $name Data name to be removed.
     *
     * @return void
     */
    public function removeData($name)
    {
        unset($this->_data[$name]);
    }

    /**
     * Method gets data from TemplateEngine::_data array.
     *
     * @param  string $name Data name to be taken.
     *
     * @return string Taken data with name $name.
     */
    public function __get($name)
    {
        if (isset($this->_data[$name])) {
            return $this->_data[$name];
        }
        return "";
    }

    /**
     * Method renders specified view. All data contained in TemplateEngine::_data array
     * will be available into the view while rendering.
     *
     * @param string $template View name.
     *
     * @return void
     */
    public function render($template)
    {
        $template = $this->_templateDir . $template;
        ob_start();
        require $template;

        $layout  = file_get_contents($this->_templateDir . 'main_layout.html.php');
        $content = str_replace('{content}', ob_get_clean(), $layout);
        echo $content;
    }
}