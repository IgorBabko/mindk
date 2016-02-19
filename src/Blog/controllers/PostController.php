<?php

namespace Blog\Controllers;

use Blog\Models\Category;
use Blog\Models\Comment;
use Blog\Models\Post;
use Blog\Models\User;
use Blog\Util;
use Framework\Config\Config;
use Framework\Controller\Controller;

class PostController extends Controller
{
    public function indexAction()
    {
        $args       = func_get_args();
        $categoryId = empty($args[0]) ? 0 : $args[0][0];
        $pageId     = empty($args[0]) ? 1 : $args[0][1];

        $session = $this->getRequest()->getSession();
        $session->start();

        $request        = $this->getRequest();
        $templateEngine = $this->getTemplateEngine();

        $posts = array();
        if ($request->isMethod('POST')) {
            if (isset($_POST['search_reset'])) {
                $session->remove('searchQuery');
                $router = $this->getRouter();
                $this->getResponseRedirect()->to(
                    $router->generateRoute('posts', array('categoryId' => 0, 'pageId' => 1))
                );
                exit();
            } else {
                $rawQueryString = "SELECT * FROM ?i WHERE ?i LIKE ?s OR ?i LIKE ?s OR ?i LIKE ?s ORDER BY ?i DESC";
                $bindParameters =
                array(
                    Post::getTable(),
                    'title',
                    '%' . $_POST['search'] . '%',
                    'small_text',
                    '%' . $_POST['search'] . '%',
                    'text',
                    '%' . $_POST['search'] . '%',
                    'posted_date',
                );

                $session->add(
                    'searchQuery',
                    array('rawQueryString' => $rawQueryString, 'bindParameters' => $bindParameters)
                );
                $session->add('categoryId', 'search');
                $router = $this->getRouter();
                $this->getResponseRedirect()->to(
                    $router->generateRoute('posts', array('categoryId' => 'search', 'pageId' => 1))
                );
            }
        } elseif ($session->exists('searchQuery') && $categoryId == $_SESSION['categoryId']) {
            $searchQuery = $session->get('searchQuery');
            $posts       = Post::query($searchQuery['rawQueryString'], $searchQuery['bindParameters']);
            $templateEngine->setData('searchResult', 'Search result: ' . count($posts) . ' items');
        } else {
            $session->remove('searchQuery');
            if ($categoryId == 0) {
                $rawQueryString = "SELECT * FROM ?i ORDER BY ?i DESC";
                $bindParameters = array(Post::getTable(), 'posted_date');
            } else {
                $category       = new Category(array('id' => $categoryId));
                $categoryName   = $category->getName();
                $rawQueryString = "SELECT * FROM ?i WHERE ?i = ?s ORDER BY ?i DESC";
                $bindParameters = array(Post::getTable(), 'category', $categoryName, 'posted_date');
            }
            $session->add('categoryId', $categoryId);
            $posts = Post::query($rawQueryString, $bindParameters);
        }

        $categories = Category::query('SELECT * FROM ?i', array(Category::getTable()));
        foreach ($categories as &$category) {
            $count = Post::query(
                "SELECT COUNT(*) AS 'count' FROM ?i WHERE ?i = ?s",
                array(Post::getTable(), 'category', $category['name'])
            );
            $category['count'] = $count[0]['count'];
        }
        $totalAmountOfPosts = Post::query('SELECT COUNT(*) AS "count" FROM ?i', array(Post::getTable()))[0]['count'];
        array_unshift($categories, array('id' => 0, 'name' => 'All', 'count' => $totalAmountOfPosts));

        $templateEngine->setData('categories', $categories);

        $itemsPerPage = Config::getSetting('pagination/items_per_page');
        $pagination   = Util::pagination(
            'posts',
            array('categoryId' => $categoryId, 'pageId' => $pageId),
            count($posts)
        );

        $start = ($pageId - 1) * $itemsPerPage;
        $templateEngine->setData('posts', array_slice($posts, $start, $itemsPerPage));
        $templateEngine->setData('router', $this->getRouter());
        $templateEngine->setData('pagination', $pagination);
        $templateEngine->render(BLOG_LAYOUT, BLOG_VIEWS . 'post/index.html.php');
    }

    public function showAction()
    {
        $session = $this->getRequest()->getSession();
        $session->start();
        $id       = func_get_args()[0][0];
        $post     = new Post(array('id' => $id));
        $comments = Comment::query(
            'SELECT * FROM ?i WHERE ?i = ?s ORDER BY ?i DESC',
            array(Comment::getTable(), 'post_title', $post->getTitle(), 'created_date')
        );
        $usersInfo    = User::query('SELECT ?i, ?i FROM ?i', array('username', 'picture_path', User::getTable()));
        $userPictures = array();
        foreach ($usersInfo as $userInfo) {
            $userPictures[$userInfo['username']] = $userInfo['picture_path'];
        }
        foreach ($comments as &$comment) {
            $comment['picture'] = $userPictures[$comment['author']];
        }

        $categories = Category::query('SELECT * FROM ?i', array(Category::getTable()));
        foreach ($categories as &$category) {
            $count = Post::query(
                "SELECT COUNT(*) AS 'count' FROM ?i WHERE ?i = ?s",
                array(Post::getTable(), 'category', $category['name'])
            );
            $category['count'] = $count[0]['count'];
        }
        $totalAmountOfPosts = Post::query('SELECT COUNT(*) AS "count" FROM ?i', array(Post::getTable()))[0]['count'];
        array_unshift($categories, array('id' => 0, 'name' => 'All', 'count' => $totalAmountOfPosts));

        $templateEngine = $this->getTemplateEngine();
        $templateEngine->setData('categories', $categories);
        $templateEngine->setData('router', $this->getRouter());
        $templateEngine->setData('post', $post);
        $templateEngine->setData('comments', $comments);
        $templateEngine->render(BLOG_LAYOUT, BLOG_VIEWS . 'post/show.html.php');
    }
}
