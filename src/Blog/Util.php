<?php
/**
 * File /src/blog/Util.php contains Util class
 * with different helper methods.
 *
 * PHP version 5
 *
 * @package Blog
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Blog;

use Framework\Config\Config;
use Framework\Routing\Router;

/**
 * Class Util.
 * Default implementation of {@link UtilInterface}.
 *
 * @package Blog
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Util //implements UtilInterface
{
    /**
     * {@inheritdoc}
     */
    public static function errorBox($errorMessage)
    {
        if (isset($errorMessage)) {
            echo "<div class='error'>$errorMessage</div>";
            return 'has-error';
        } else {
            return '';
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function pagination($routeName, $routeParams, $totalNumOfItems)
    {
        $currentPageId = $routeParams['pageId'];
        $itemsPerPage = Config::getSetting('pagination/items_per_page');
        $visiblePages = Config::getSetting('pagination/visible_pages');
        $router = Router::getInstance();

        $amountOfPages = ceil($totalNumOfItems / $itemsPerPage);

        if ($amountOfPages == 1 || $totalNumOfItems == 0) {
            return '';
        }

        if ($amountOfPages < $visiblePages) {
            $visiblePages = $amountOfPages;
        }

        $pagination = "<ul class='pagination'>";

        if ($routeParams['pageId'] == 1) {
            $pagination .= "<li class='disabled'><a href='javascript:void(0)'>First</a></li>";
            $pagination .= "<li class='disabled'><a href='javascript:void(0)'><<</a></li>";
        } else {
            $routeParams['pageId'] = 1;
            $pagination .= "<li><a href='" . $router->generateRoute($routeName, $routeParams) . "'>First</a></li>";
            $routeParams['pageId'] = $currentPageId - 1;
            $pagination .= "<li><a href='" . $router->generateRoute(
                    $routeName,
                    $routeParams
                ) . "'><<</a></li>";
        }

        $i = $currentPageId - floor($visiblePages / 2);
        if ($i < 1) {
            $i = 1;
        }

        $end = $i + $visiblePages - 1;
        if ($end > $amountOfPages) {
            $end = $amountOfPages;
            $i = $amountOfPages - $visiblePages + 1;
        }

        for (; ($i <= $end && $i <= $amountOfPages); $i++) {
            if ($currentPageId == $i) {
                $pagination .= "<li class='active'><a href='javascript:void(0)'>$i</a></li>";
            } else {
                $routeParams['pageId'] = $i;
                $pagination .= "<li><a href='" . $router->generateRoute(
                        $routeName,
                        $routeParams
                    ) . "'>$i</a></li>";
            }
        }

        if ($currentPageId == $amountOfPages) {
            $pagination .= "<li class='disabled'><a href='javascript:void(0)'>>></a></li>";
            $pagination .= "<li class='disabled'><a href='javascript:void(0)'>Last</a></li>";
        } else {
            $routeParams['pageId'] = $currentPageId + 1;
            $pagination .= "<li><a href='" . $router->generateRoute(
                    $routeName,
                    $routeParams
                ) . "'>>></a></li>";
            $routeParams['pageId'] = $amountOfPages;
            $pagination .= "<li><a href='" . $router->generateRoute(
                    $routeName,
                    $routeParams
                ) . "'>Last</a></li>";
        }
        $pagination .= '</ul>';
        return $pagination;
    }
}