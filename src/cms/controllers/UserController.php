<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/15/14
 * Time: 12:49 PM
 */

namespace CMS\Controllers;

use Blog\Util;
use CMS\Models\User;
use Framework\Config\Config;
use Framework\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $pageId  = func_get_args()[0][0];
        $session = $this->getRequest()->getSession();
        $session->start();

        $request        = $this->getRequest();
        $templateEngine = $this->getTemplateEngine();
        $rawQueryString = "SELECT ?i, ?i, ?i FROM ?i";
        $bindParameters = array('id', 'username', 'email', User::getTable());

        $columnNames = User::getColumns();
        if ($request->isMethod('POST')) {

            if (isset($_POST['search_user_reset'])) {
                $session->remove('searchUserQuery');

                $router = $this->getRouter();
                $this->getResponseredirect()->to($router->generateRoute('show_users', array('pageId' => 1)));
                exit();
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
                $session->add('searchUserQuery', array('rawQueryString' => $rawQueryString, 'bindParameters' => $bindParameters));

                $router = $this->getRouter();
                $this->getResponseredirect()->to($router->generateRoute('show_users', array('pageId' => 1)));
                exit();
            }
        } elseif ($session->exists('searchUserQuery')) {
            $searchUserQuery = $session->get('searchUserQuery');
            $users = User::query($searchUserQuery['rawQueryString'], $searchUserQuery['bindParameters']);
            $templateEngine->setData('searchResult', 'Search result: '.count($users).' items');
        } else {
            $users = User::query($rawQueryString, $bindParameters);
        }

        $itemsPerPage = Config::getSetting('pagination/items_per_page');
        $pagination   = Util::pagination('show_users', array('pageId' => $pageId), count($users));

        $start = ($pageId - 1) * $itemsPerPage;
        $templateEngine->setData('users', array_slice($users, $start, $itemsPerPage));
        $templateEngine->setData('router', $this->getRouter());
        $templateEngine->setData('pagination', $pagination);
        $templateEngine->render(CMS_LAYOUT, CMS_VIEWS.'user/index.html.php');
    }

    public function showAction()
    {
        $id             = func_get_args()[0][0];
        $user           = new User(array('id' => $id));
        $templateEngine = $this->getTemplateEngine();
        $templateEngine->setData('router', $this->getRouter());
        $templateEngine->setData('user', $user);

        $templateEngine->render(CMS_LAYOUT, CMS_VIEWS.'user/show.html.php');
    }

    public function deleteAction()
    {
        $session = $this->getRequest()->getSession();
        $session->start();

        $id       = func_get_args()[0][0];
        $user     = new User(array('id' => $id));
        $username = $user->getUsername();
        $user->remove();

        $router  = $this->getRouter();
        $session->flash('user_deleted', "<div class='flash-success well well-sm'>User '$username' has been deleted successfully!</div>");
        if ($_SESSION['user']['name'] === $username) {
            unset($_SESSION['user']);
            $this->getResponseRedirect()->route('home');
        } else {
            $this->getResponseRedirect()->to($router->generateRoute('show_users', array('pageId' => 1)));
        }
    }
}