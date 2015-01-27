<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/15/14
 * Time: 12:49 PM
 */

namespace CMS\Controllers;

use Blog\Util;
use CMS\Models\Comment;
use CMS\Models\Post;
use Framework\Config\Config;
use Framework\Controller\Controller;
use Framework\Exception\FrameworkException;
use Framework\Model\Form;
use Framework\Validation\Validator;

class CommentController extends Controller
{
    public function indexAction()
    {
        $pageId  = func_get_args()[0][0];
        $session = $this->getRequest()->getSession();
        $session->start();

        $request        = $this->getRequest();
        $templateEngine = $this->getTemplateEngine();
        $rawQueryString = "SELECT ?i, ?i, ?i FROM ?i";
        $bindParameters = array('id', 'author', 'post_title', Comment::getTable());

        $columnNames = Comment::getColumns();
        if ($request->isMethod('POST')) {

            if (isset($_POST['search_comment_reset'])) {
                $session->remove('searchCommentQuery');

                $router = $this->getRouter();
                $this->getResponseredirect()->to($router->generateRoute('show_comments', array('pageId' => 1)));
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
                $session->add('searchCommentQuery', array('rawQueryString' => $rawQueryString, 'bindParameters' => $bindParameters));
                $router = $this->getRouter();
                $this->getResponseredirect()->to($router->generateRoute('show_comments', array('pageId' => 1)));
                exit();
            }
        } elseif ($session->exists('searchCommentQuery')) {
            $searchCommentQuery = $session->get('searchCommentQuery');
            $comments = Comment::query($searchCommentQuery['rawQueryString'], $searchCommentQuery['bindParameters']);
            $templateEngine->setData('searchResult', 'Search result: '.count($comments).' items');
        } else {
            $comments = Comment::query($rawQueryString, $bindParameters);
        }

        $itemsPerPage = Config::getSetting('pagination/items_per_page');
        $pagination   = Util::pagination('show_comments', array('pageId' => $pageId), count($comments));

        $start = ($pageId - 1) * $itemsPerPage;
        $templateEngine->setData('comments', array_slice($comments, $start, $itemsPerPage));
        $templateEngine->setData('router', $this->getRouter());
        $templateEngine->setData('pagination', $pagination);
        $templateEngine->render(CMS_LAYOUT, CMS_VIEWS.'comment/index.html.php');
    }

    public function showAction()
    {
        $id             = func_get_args()[0][0];
        $comment        = new Comment(array('id' => $id));
        $templateEngine = $this->getTemplateEngine();
        $templateEngine->setData('router', $this->getRouter());
        $templateEngine->setData('comment', $comment);

        $templateEngine->render(CMS_LAYOUT, CMS_VIEWS.'comment/show.html.php');
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $request->getSession()->start();
        $templateEngine = $this->getTemplateEngine();
        $templateEngine->setData('router', $this->getRouter());
        $posts = Post::query("SELECT ?i FROM ?i", array('title', Post::getTable()));
        $templateEngine->setData('posts', $posts);

        if ($request->isMethod('POST')) {
            try{
                $comment     = new Comment();
                $commentForm = new Form($comment, 'add');

                if ($commentForm->isValid()) {
                    $commentForm->bindDataToModel();
                    $comment->setAuthor($_SESSION['user']['name']);
                    $comment->setCreatedDate(date('Y-m-d H:i:s'));
                    $comment->save();

                    $session = $this->getRequest()->getSession();
                    $session->start();
                    $session->flash('comment_added', "<div class='flash-success well well-sm'>Comment has been added successfully!</div>");
                    $this->getResponseRedirect()->route('show_comments');
                    exit();
                } else {
                    $errors = Validator::getErrorList();
                    $templateEngine->setData('errors', $errors);
                    $templateEngine->render(CMS_LAYOUT, CMS_VIEWS.'comment/add.html.php');
                }
            } catch(FrameworkException $e){
                $templateEngine->setData('exception', $e);
                $templateEngine->render(CMS_LAYOUT, CMS_VIEWS.'error.html.php');
            }
        } else {
            $templateEngine->render(CMS_LAYOUT, CMS_VIEWS.'comment/add.html.php');
        }
    }

    public function deleteAction()
    {
        $id      = func_get_args()[0][0];
        $comment = new Comment(array('id' => $id));
        $comment->remove();

        $session = $this->getRequest()->getSession();
        $session->start();
        $session->flash('comment_deleted', "<div class='flash-success well well-sm'>Comment has been deleted successfully!</div>");
        $this->getResponseRedirect()->route('show_comments');
    }
}