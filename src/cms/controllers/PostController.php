<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/15/14
 * Time: 12:49 PM
 */

namespace CMS\Controllers;

use CMS\Models\Comment;
use CMS\Models\Post;
use CMS\Models\Category;
use Framework\Config\Config;
use Framework\Controller\Controller;
use Framework\Exception\FrameworkException;
use Framework\Model\Form;
use Framework\Sanitization\Filter\FHtmlEntity;
use Framework\Sanitization\Sanitizer;
use Framework\Validation\Validator;
use Blog\Util;

class PostController extends Controller
{
    public function indexAction()
    {
        $pageId = func_get_args()[0][0];
        $session = $this->getRequest()->getSession();
        $session->start();

        $request = $this->getRequest();
        $templateEngine = $this->getTemplateEngine();
        $rawQueryString = "SELECT ?i, ?i, ?i FROM ?i";
        $bindParameters = array('id', 'category', 'title', Post::getTable());

        $columnNames = Post::getColumns();
        if ($request->isMethod('POST')) {

            if (isset($_POST['search_post_reset'])) {
                $session->remove('searchPostQuery');

                $router = $this->getRouter();
                $this->getResponseredirect()->to($router->generateRoute('show_posts', array('pageId' => 1)));

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
                $session->add(
                    'searchPostQuery',
                    array('rawQueryString' => $rawQueryString, 'bindParameters' => $bindParameters)
                );

                $router = $this->getRouter();
                $this->getResponseredirect()->to($router->generateRoute('show_posts', array('pageId' => 1)));
                exit();
            }
        } elseif ($session->exists('searchPostQuery')) {
            $searchPostQuery = $session->get('searchPostQuery');
            $posts = Post::query($searchPostQuery['rawQueryString'], $searchPostQuery['bindParameters']);
            $templateEngine->setData('searchResult', 'Search result: ' . count($posts) . ' items');
        } else {
            $posts = Post::query($rawQueryString, $bindParameters);
        }

        $itemsPerPage = Config::getSetting('pagination/items_per_page');
        $pagination = Util::pagination('show_posts', array('pageId' => $pageId), count($posts));

        $start = ($pageId - 1) * $itemsPerPage;
        $templateEngine->setData('posts', array_slice($posts, $start, $itemsPerPage));
        $templateEngine->setData('router', $this->getRouter());
        $templateEngine->setData('pagination', $pagination);
        $templateEngine->render(CMS_LAYOUT, CMS_VIEWS . 'post/index.html.php');
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $templateEngine = $this->getTemplateEngine();
        $templateEngine->setData('router', $this->getRouter());
        $categories = Category::query("SELECT ?i FROM ?i", array('name', Category::getTable()));
        $templateEngine->setData('categories', $categories);

        if ($request->isMethod('POST')) {
            try {
                $post = new Post();
                $postForm = new Form($post, 'add');

                if ($postForm->isValid()) {
                    $postForm->bindDataToModel();
                    $post->setPostedDate(date('Y-m-d H:i:s'));
                    Sanitizer::sanitize($post);
                    $post->save();
                    $postTitle = $post->getTitle();
                    $router = $this->getRouter();
                    $session = $this->getRequest()->getSession();
                    $session->start();
                    $session->flash(
                        'post_added',
                        "<div class='flash-success well well-sm'>Post '$postTitle' has been added successfully!</div>"
                    );
                    $this->getResponseRedirect()->to($router->generateRoute('show_posts', array('pageId' => 1)));
                    exit();
                } else {
                    $errors = Validator::getErrorList();
                    $templateEngine->setData('errors', $errors);
                    $templateEngine->render(CMS_LAYOUT, CMS_VIEWS . 'post/add.html.php');
                }
            } catch (FrameworkException $e) {
                $templateEngine->setData('exception', $e);
                $templateEngine->render(CMS_LAYOUT, CMS_VIEWS . 'error.html.php');
            }
        } else {
            $templateEngine->render(CMS_LAYOUT, CMS_VIEWS . 'post/add.html.php');
        }
    }

    public function editAction()
    {
        $id = func_get_args()[0][0];
        $categories = Category::query("SELECT ?i FROM ?i", array('name', Category::getTable()));
        $request = $this->getRequest();
        $templateEngine = $this->getTemplateEngine();
        $templateEngine->setData('router', $this->getRouter());
        $templateEngine->setData('categories', $categories);
        $templateEngine->setData('id', $id);

        $post = new Post(array('id' => $id));
        $_POST['_category'] = isset($_POST['_category']) ? $_POST['_category'] : $post->getCategory();
        $_POST['_title'] = isset($_POST['_title']) ? $_POST['_title'] : $post->getTitle();
        $_POST['_smallText'] = isset($_POST['_smallText']) ? $_POST['_smallText'] : $post->getSmallText();
        $_POST['_text'] = isset($_POST['_text']) ? $_POST['_text'] : $post->getText();
        $_POST['_amountOfComments'] = $post->getAmountOfComments();

        if ($request->isMethod('POST')) {
            try {
                $postForm = new Form($post, 'edit');

                if ($postForm->isValid()) {

                    $session = $this->getRequest()->getSession();
                    $session->start();
                    $postForm->bindDataToModel();
                    Sanitizer::sanitize($post);
                    $post->save(array('id' => $id));
                    $postTitle = $post->getTitle();

                    $router = $this->getRouter();
                    $session->flash(
                        'post_updated',
                        "<div class='flash-success well well-sm'>Post '$postTitle' has been updated successfully!</div>"
                    );
                    $this->getResponseRedirect()->to($router->generateRoute('show_posts', array('pageId' => 1)));
                    exit();
                } else {
                    $errors = Validator::getErrorList();
                    $templateEngine->setData('errors', $errors);
                    $templateEngine->render(CMS_LAYOUT, CMS_VIEWS . 'post/edit.html.php');
                }
            } catch (FrameworkException $e) {
                $templateEngine->setData('exception', $e);
                $templateEngine->render(CMS_LAYOUT, CMS_VIEWS . 'error.html.php');
            }
        } else {
            $templateEngine->render(CMS_LAYOUT, CMS_VIEWS . 'post/edit.html.php');
        }
    }

    public function deleteAction()
    {
        $id = func_get_args()[0][0];
        $post = new Post(array('id' => $id));
        $postTitle = $post->getTitle();
        $post->remove();

        Comment::query('DELETE FROM ?i WHERE ?i = ?s', array(Comment::getTable(), 'post_title', $postTitle));

        $router = $this->getRouter();
        $session = $this->getRequest()->getSession();
        $session->start();
        $session->flash(
            'post_deleted',
            "<div class='flash-success well well-sm'>Post '$postTitle' has been deleted successfully!</div>"
        );
        $this->getResponseRedirect()->to($router->generateRoute('show_posts', array('pageId' => 1)));
    }
}