<?php
/**
 * File /framework/template/TemplateEngineInterface.php contains TemplateEngineInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Template
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Template;

/**
 * Interface TemplateEngineInterface is used to be implemented by TemplateEngine class.
 *
 * @api
 *
 * @package Framework\Template
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface TemplateEngineInterface
{
    /**
     * Method to get data that will be available in view rendering.
     *
     * @return array Data.
     */
    public function getData();

    /**
     * Method sets data to be used in view.
     *
     * @param  string $name Data name;
     * @param  mixed $value Data itself.
     *
     * @throws \Framework\Exception\TemplateEngineException TemplateEngineException instance.
     *
     * @return void
     */
    public function setData($name, $value);

    /**
     * Method removes data with key $key from
     * TemplateEngine::_data array.
     *
     * @param  string $key Key of data to be removed.
     *
     * @return void
     */
    public function removeData($key);

    /**
     * Method gets data from TemplateEngine::_data array.
     *
     * @param  string $key Key of data to be taken.
     *
     * @return mixed  Data from TemplateEngine::_data array or NULL if data with specified key doesn't exist.
     */
    public function __get($key);

    /**
     * Method renders pages with specified view. All data contained in TemplateEngine::_data array
     * will be available into the view while rendering.
     *
     * @param  string $layout Path to layout.
     * @param  string $view Path to view.
     *
     * @return void
     */
    public function render($layout, $view);
}