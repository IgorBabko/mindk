<?php

namespace Blog\Controllers;

use Blog\Models\Post;
use CMS\Models\Category;
use Framework\Controller\Controller;

class PageController extends Controller
{
    public function aboutAction()
    {
        $session = $this->getRequest()->getSession();
        $session->start();
        $templateEngine = $this->getTemplateEngine();
        $categories     = Category::query('SELECT * FROM ?i', array(Category::getTable()));
        foreach ($categories as &$category) {
            $count             = Post::query(
                "SELECT COUNT(*) AS 'count' FROM ?i WHERE ?i = ?s",
                array(Post::getTable(), 'category', $category['name'])
            );
            $category['count'] = $count[0]['count'];
        }
        $totalAmountOfPosts = Post::query('SELECT COUNT(*) AS "count" FROM ?i', array(Post::getTable()))[0]['count'];
        array_unshift($categories, array('id' => 0, 'name' => 'All', 'count' => $totalAmountOfPosts));

        $templateEngine->setData('categories', $categories);
        $this->getTemplateEngine()->render(BLOG_LAYOUT, BLOG_VIEWS.'page/about.html.php');
    }

//    public function dashboardAction()
//    {
//        $templateEngine = $this->getTemplateEngine();
//        $categories     = Category::query('SELECT * FROM ?i', array(Category::getTable()));
//        foreach ($categories as &$category) {
//            $count             = Post::query(
//                "SELECT COUNT(*) AS 'count' FROM ?i WHERE ?i = ?s",
//                array(Post::getTable(), 'category', $category['name'])
//            );
//            $category['count'] = $count[0]['count'];
//        }
//        $totalAmountOfPosts = Post::query('SELECT COUNT(*) AS "count" FROM ?i', array(Post::getTable()))[0]['count'];
//        array_unshift($categories, array('id' => 0, 'name' => 'All', 'count' => $totalAmountOfPosts));
//
//        $templateEngine->setData('categories', $categories);
//        $this->getTemplateEngine()->render(BLOG_LAYOUT, BLOG_VIEWS.'page/dashboard.html.php');
//    }
}