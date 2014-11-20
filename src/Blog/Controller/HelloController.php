<?php
/**
 * /src/Blog/Controller/HelloController.php contains HelloController class.
 *
 * PHP version 5
 *
 * @package Blog\Controller
 * @author  Igor Babko
 */

namespace Blog\Controller;

use Framework\Application;
use Framework\Controller\Controller;

/**
 * Class HelloController
 *
 * @package Blog\Controller
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class HelloController extends Controller
{
    /**
     * Method calls TemplateEngine::render method to render Hello/index.html.php view.
     */
    public function indexAction()
    {
        Application::getTemplateEngine()->render('Hello/index.html.php');
    }
}