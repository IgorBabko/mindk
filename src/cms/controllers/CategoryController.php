<?php

namespace CMS\Controllers;

use Blog\Util;
use CMS\Models\Category;
use Framework\Config\Config;
use Framework\Controller\Controller;
use Framework\Exception\FrameworkException;
use Framework\Model\Form;
use Framework\Validation\Validator;

class CategoryController extends Controller
{
    public function indexAction()
    {
        $pageId = func_get_args()[0][0];
        $session = $this->getRequest()->getSession();
        $session->start();

        $request = $this->getRequest();
        $templateEngine = $this->getTemplateEngine();
        $rawQueryString = "SELECT * FROM ?i";
        $bindParameters = array(Category::getTable());

        $columnNames = Category::getColumns();
        if ($request->isMethod('POST')) {

            if (isset($_POST['search_category_reset'])) {
                $session->remove('searchCategoryQuery');

                $router = $this->getRouter();
                $this->getResponseredirect()->to($router->generateRoute('show_categories', array('pageId' => 1)));
                exit();
            } else {
                $k = false;
                foreach ($_POST as $fieldName => $fieldValue) {
                    if (!empty($fieldValue)) {
                        if (!is_numeric($fieldValue)) {
                            $queryPart = " LIKE ?s";
                            $fieldValue = '%' . $fieldValue . '%';
                        } else {
                            $queryPart = " = ?n";
                            $fieldValue = (int)$fieldValue;
                        }

                        if ($k === true) {
                            $rawQueryString .= " AND ?i" . $queryPart;
                        } else {
                            $rawQueryString .= " WHERE ?i" . $queryPart;
                            $k = true;
                        }

                        $bindParameters = array_merge($bindParameters, array($columnNames[$fieldName], $fieldValue));
                    }
                }
                $session->add('searchCategoryQuery', array('rawQueryString' => $rawQueryString, 'bindParameters' => $bindParameters));

                $router = $this->getRouter();
                $this->getResponseredirect()->to($router->generateRoute('show_categories', array('pageId' => 1)));
                exit();
            }
        } elseif ($session->exists('searchCategoryQuery')) {
            $searchCategoryQuery = $session->get('searchCategoryQuery');
            $categories = Category::query($searchCategoryQuery['rawQueryString'], $searchCategoryQuery['bindParameters']);
            $templateEngine->setData('searchResult', 'Search result: ' . count($categories) . ' items');
        } else {
            $categories = Category::query($rawQueryString, $bindParameters);
        }

        $itemsPerPage = Config::getSetting('pagination/items_per_page');
        $pagination = Util::pagination('show_categories', array('pageId' => $pageId), count($categories));

        $start = ($pageId - 1) * $itemsPerPage;
        $templateEngine->setData('categories', array_slice($categories, $start, $itemsPerPage));
        $templateEngine->setData('router', $this->getRouter());
        $templateEngine->setData('pagination', $pagination);
        $templateEngine->render(CMS_LAYOUT, CMS_VIEWS . 'category/index.html.php');
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $templateEngine = $this->getTemplateEngine();
        $templateEngine->setData('router', $this->getRouter());

        if ($request->isMethod('POST')) {
            try {
                $category = new Category();
                $categoryForm = new Form($category, 'add');

                if ($categoryForm->isValid()) {
                    $categoryForm->bindDataToModel();
                    $category->save();
                    $categoryName = $category->getName();

                    $router = $this->getRouter();
                    $session->start();
                    $session->flash('category_added', "<div class='flash-success well well-sm'>Category '$categoryName' has been added successfully!</div>");
                    $this->getResponseRedirect()->to($router->generateRoute('show_categories', array('pageId' => 1)));
                    exit();
                } else {
                    $errors = Validator::getErrorList();
                    $templateEngine->setData('errors', $errors);
                    $templateEngine->render(CMS_LAYOUT, CMS_VIEWS . 'category/add.html.php');
                }
            } catch (FrameworkException $e) {
                $templateEngine->setData('exception', $e);
                $templateEngine->render(CMS_LAYOUT, CMS_VIEWS . 'error.html.php');
            }
        } else {
            $templateEngine->render(CMS_LAYOUT, CMS_VIEWS . 'category/add.html.php');
        }
    }

    public function editAction()
    {
        $id = func_get_args()[0][0];
        $request = $this->getRequest();
        $session = $request->getSession();
        $templateEngine = $this->getTemplateEngine();
        $templateEngine->setData('router', $this->getRouter());
        $templateEngine->setData('id', $id);
        $category = new Category(array('id' => $id));
        $_POST['_name'] = isset($_POST['_name']) ? $_POST['_name'] : $category->getName();

        if ($request->isMethod('POST')) {
            try {
                $categoryForm = new Form($category, 'edit');

                if ($categoryForm->isValid()) {
                    $categoryName = $category->getName();
                    $categoryForm->bindDataToModel();
                    $category->save(array('name' => $categoryName));
                    $categoryName = $category->getName();

                    $router = $this->getRouter();
                    $session->start();
                    $session->flash('category_updated', "<div class='flash-success well well-sm'>Category '$categoryName' has been updated successfully!</div>");
                    $this->getResponseRedirect()->to($router->generateRoute('show_categories', array('pageId' => 1)));
                    exit();
                } else {
                    $errors = Validator::getErrorList();
                    $templateEngine->setData('errors', $errors);
                    $templateEngine->render(CMS_LAYOUT, CMS_VIEWS . 'category/edit.html.php');
                }
            } catch (FrameworkException $e) {
                $templateEngine->setData('exception', $e);
                $templateEngine->render(CMS_LAYOUT, CMS_VIEWS . 'error.html.php');
            }
        } else {
            $templateEngine->render(CMS_LAYOUT, CMS_VIEWS . 'category/edit.html.php');
        }
    }

    public function deleteAction($id)
    {
        $id = func_get_args()[0][0];
        $category = new Category(array('id' => $id));
        $categoryName = $category->getName();
        $category->remove();

        $router = $this->getRouter();
        $request = $this->getRequest();
        $session = $request->getSession();
        $session->start();
        $session->flash('category_deleted', "<div class='flash-success well well-sm'>Category '$categoryName' has been deleted successfully!</div>");
        $this->getResponseRedirect()->to($router->generateRoute('show_categories', array('pageId' => 1)));
    }
}