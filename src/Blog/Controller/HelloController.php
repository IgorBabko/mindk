<?php
/**
 * Created by PhpStorm.
 * User: mchurylov
 * Date: 10/15/14
 * Time: 12:49 PM
 */

namespace Blog\Controller;


class HelloController extends \Framework\Controller
{
    public function indexAction()
    {
        return $this->render('Hello/index.html.php');
    }
}