<?php

namespace CMS\Controllers;

use Framework\Controller\Controller;

class PageController extends Controller
{
    public function dashboardAction()
    {
        $this->getTemplateEngine()->render(CMS_LAYOUT, CMS_VIEWS . 'page/index.html.php');
    }
}