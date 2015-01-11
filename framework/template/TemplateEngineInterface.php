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
     * @param  mixed  $value Data itself.
     *
     * @throws \Framework\Exception\TemplateEngineException TemplateEngineException instance.
     *
     * @return void
     */
    public function setData($name, $value);

//    /**
//     * Method to get template directory.
//     *
//     * @return string Template directory.
//     */
//    public function getTemplateDir();

//    /**
//     * Method to set template directory.
//     *
//     * @param  string $templateDir Template directory.
//     *
//     * @throws \Framework\Exception\TemplateEngineException TemplateEngineException instance.
//     *
//     * @return void
//     */
//    public function setTemplateDir($templateDir);

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
     * Also it puts flash messages of session into TemplateEngine::_data array under key 'flashMsgs'
     * After page rendering all flash messages will be removed from session.
     *
     * Note: flash message is message that exists until next redirection.
     *
     * @param  string $viewPath Path to the view.
     *
     * @return void
     */
    public function render($viewPath);
}