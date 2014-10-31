<?php
/**
 * Created by PhpStorm.
 * User: mchurylov
 * Date: 10/15/14
 * Time: 12:49 PM
 */

namespace Blog\Controller;

use \Framework\Controller;
use \Framework\Loader;

Loader::core('controller');

class HelloController extends Controller
{
    public function indexAction()
    {
        return $this->render(VIEWS . 'Hello/index.html.php');
    }
}