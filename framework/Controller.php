<?php
/**
 * File /framework/Controller.php contains Controller superclass
 * which will be inherited by all controllers.
 *
 * PHP version 5
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

/**
 * Class Controller is superclass for all controllers.
 *
 * Class holds all necessary fields and method for all controllers.
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Controller
{

    /**
     * @var string $controller Name of controller
     */
    protected $controller;
    /**
     * @var string $action Name of action
     */
    protected $action;
    /**
     * @var array $params Params used in particular action of controller
     */
    protected $params;

    /**
     * @param string $name   Name of view to render.
     * @param array  $params Params used in view.
     *
     * @return void
     */
    public function render($name, $params = array())
    {

        $name = VIEWS.$name;

        if (file_exists($name)) {
            $content = require $name;
        } else {
            $content = $name;
        }

        echo $content;
    }
}