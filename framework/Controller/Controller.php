<?php
/**
 * File /Framework/Controller/Controller.php contains Controller superclass
 * which will be inherited by all controllers.
 *
 * PHP version 5
 *
 * @package Framework\Controller
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Controller;

/**
 * Class Controller is superclass for all controllers.
 *
 * Class holds all necessary fields and method for all controllers.
 *
 * @package Framework\Controller
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Controller
{
    /**
     * @var string $controller Name of controller
     */
    public $controller = 'HelloController';
    /**
     * @var string $action Name of action
     */
    public $action = 'index';
    /**
     * @var array $params Params used in particular action of controller
     */
    public $params = array();
}