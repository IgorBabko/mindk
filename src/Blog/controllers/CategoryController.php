<?php

namespace Blog\Controllers;

use Blog\Util;
use CMS\Models\Category;
use Framework\Config\Config;
use Framework\Controller\Controller;

class CategoryController extends Controller
{
    public function indexAction()
    {
        $pageId  = func_get_args()[0][0];
        $session = $this->getRequest()->getSession();
        $session->start();

        $request        = $this->getRequest();
        $templateEngine = $this->getTemplateEngine();
        $rawQueryString = "SELECT * FROM ?i";
        $bindParameters = array(Category::getTable());

        $columnNames = Category::getColumns();
        if ($request->isMethod('POST')) {

            if (isset($_POST['search_category_reset'])) {
                $session->remove('searchCategoryQuery');
                $categories = Category::query($rawQueryString, $bindParameters);
            } else {
                $k = false;
                foreach ($_POST as $fieldName => $fieldValue) {
                    if (!empty($fieldValue)) {
                        if (!is_numeric($fieldValue)) {
                            $queryPart  = " LIKE ?s";
                            $fieldValue = '%'.$fieldValue.'%';
                        } else {
                            $queryPart  = " = ?n";
                            $fieldValue = (int)$fieldValue;
                        }

                        if ($k === true) {
                            $rawQueryString .= " AND ?i".$queryPart;
                        } else {
                            $rawQueryString .= " WHERE ?i".$queryPart;
                            $k = true;
                        }

                        $bindParameters = array_merge($bindParameters, array($columnNames[$fieldName], $fieldValue));
                    }
                }
                $session->add('searchCategoryQuery', array('rawQueryString' => $rawQueryString, 'bindParameters' => $bindParameters));
                $categories = Category::query($rawQueryString, $bindParameters);
                $templateEngine->setData('searchResult', 'Search result: '.count($categories).' items');
            }
        } elseif ($session->exists('searchCategoryQuery')) {
            $searchCategoryQuery = $session->get('searchCategoryQuery');
            $categories = Category::query($searchCategoryQuery['rawQueryString'], $searchCategoryQuery['bindParameters']);
            $templateEngine->setData('searchResult', 'Search result: '.count($categories).' items');
        } else {
            $categories = Category::query($rawQueryString, $bindParameters);
        }

        $itemsPerPage = Config::getSetting('pagination/items_per_page');
        $pagination   = Util::pagination('categories', $pageId, count($categories));

        $start = ($pageId - 1) * $itemsPerPage;
        $templateEngine->setData('categories', array_slice($categories, $start, $itemsPerPage));
        $templateEngine->setData('router', $this->getRouter());
        $templateEngine->setData('pagination', $pagination);
        $templateEngine->render(CMS_LAYOUT, CMS_VIEWS.'category/index.html.php');
    }
}