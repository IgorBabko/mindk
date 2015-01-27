<?php
$isRouteActive = function ($currentRoute) {
    return ($this->activeRoute === $currentRoute)?'class="active"':'';
};
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
    <title>Education</title>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CodeMirror -->
    <link href="/web/css/codeMirror/docs.css" rel="stylesheet"/>
    <link href="/web/css/codeMirror/codemirror.css" rel="stylesheet"/>
    <link href="/web/css/codeMirror/themes/twilight.css" type="text/css" rel="stylesheet" />
    <link href="/web/css/codeMirror/themes/monokai.css" type="text/css" rel="stylesheet" />
    <!-- End CodeMirror -->

    <link href="/web/css/reset.css" rel="stylesheet">
    <link href="/web/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
    <link href="/web/css/bootstrap-theme.min.css" type="text/css" rel="stylesheet"/>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet"/>

    <link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700'
          rel='stylesheet' type='text/css'/>
    <link href="/web/css/theme.css" rel="stylesheet"/>
</head>

<body role="document" id="blog">

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://mindk.com"><img class="brand-logo"
                                                                 src="/web/images/img-logo-mindk-white.png"
                                                                 alt="Education"></a>
        </div>
        <div class="navbar-collapse collapse" id="main-menu">
            <ul class="nav navbar-nav">
                <li <?= $isRouteActive('home'); ?> ><a
                        href="<?= $this->router->generateRoute('home'); ?>">Home</a>
                </li>
                <li <?= $isRouteActive('about'); ?> ><a href="<?= $this->router->generateRoute('about'); ?>">About</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (!isset($_SESSION['user'])) { ?>
                    <li <?= $isRouteActive('login'); ?>  ><a
                            href="<?= $this->router->generateRoute('login'); ?>">Log in</a></li>
                    <li <?= $isRouteActive('signup'); ?> ><a
                            href="<?= $this->router->generateRoute('signup'); ?>">Sign up</a></li>
                <?php } else { ?>
                    <li <?= $isRouteActive('update'); ?> ><a
                            href="<?= $this->router->generateRoute('update'); ?>">Profile</a></li>
                    <li <?= $isRouteActive('logout'); ?> ><a
                            href="<?= $this->router->generateRoute('logout'); ?>">Log out</a></li>
                <?php } ?>
                <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'ADMIN') { ?>
                    <li <?= $isRouteActive('dashboard'); ?> ><a
                            href="<?= $this->router->generateRoute('dashboard'); ?>">Dashboard</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<div id="under_navbar"></div>
<div id="header">
    <img src="/web/images/web_header5_quote.png">
</div>

<div id="main_container">
    <div id="content">
        <?php
        if (isset($_SESSION['flashMsgs'])) {
            foreach ($_SESSION['flashMsgs'] as $message) {
                echo $message;
            }
            unset($_SESSION['flashMsgs']);
        }
        ?>
        <form id="reset_form"
              action="<?= $this->router->generateRoute('posts', array('categoryId' => 0, 'pageId' => 1)); ?>"
              method="post">
            <input id="search_reset" type="hidden" name="search_reset">
        </form>
        <form id="search" role="search"
              action="<?= $this->router->generateRoute(
                  'posts',
                  array('categoryId' => ($this->categoryId != null)?$this->categoryId:0, 'pageId' => 1)
              ); ?>" name="search-form" method="post">
            <div class="input-group">
                <span class="input-group-btn"><button
                        type="submit" <?= isset($_SESSION['searchQuery'])?'':'disabled'; ?>
                        form="reset_form"
                        class="btn btn-info">Reset
                    </button>
                </span>
                <input autocomplete="off" type="search" class="form-control" name="search"
                       value="<?= isset($_POST['search'])?$_POST['search']:''; ?>"
                       placeholder="<?= ($this->searchResult != null)?$this->searchResult:'Search for...'; ?>"/>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-warning">Go!</span>
                    </button>
                </span>
            </div>
        </form>
        <hr/>
        <ul id="nav-categories" class="nav nav-justified hidden-lg">
            <?php
            if ($this->activeRoute != 'home' && $this->activeRoute != 'posts') {
                $categoryId = null;
            } else {
                $categoryId = (int)$_SESSION['categoryId'];
            }
            foreach ($this->categories as $category) {
            ?><li role="presentation" <?= ($categoryId === (int)$category['id'])?'id="active_category"':''; ?> ><a href="<?= $this->router->generateRoute('posts', array('categoryId' => $category['id'], 'pageId' => 1)); ?>"><?= $category['name']; ?></a></li><?php } ?>
        </ul>
        <?= $this->view; ?>
    </div>
    <div id="sidebar" class="hidden-xs hidden-sm hidden-md">
        <div class="panel panel-black">
            <div class="panel-heading panel-title">
                Categories
            </div>

            <div class="panel-body">
                <ul class="list-group" id="categories">
                    <?php
                    if ($this->activeRoute != 'home' && $this->activeRoute != 'posts') {
                        $categoryId = null;
                    } else {
                        $categoryId = (int)$_SESSION['categoryId'];
                    }
                    foreach ($this->categories as $category) {
                    ?>
                        <a href="<?= $this->router->generateRoute(
                            'posts',
                            array('categoryId' => $category['id'], 'pageId' => 1)
                        ); ?>">
                            <li <?= ($categoryId === (int)$category['id'])?'id="active_category"':''; ?>
                                class="list-group-item"><span
                                    class="badge"><?= $category['count']; ?></span><?= $category['name']; ?></li>
                        </a>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <img src="/web/images/pencils.png">
    </div>
    <div class="clear"></div>
</div>

<div class="scrollToTop">
    <img id="arrow_up" src="/web/images/arrow_up.png">
</div>

<div id="footer">
    <div class="footer-top">
        <div id="footer-icons">
            <a class="footer_img" id="html_img" href="<?= $this->router->generateRoute('posts', array('categoryId' => 1, 'pageId' => 1)); ?>"></a>
            <a class="footer_img" id="css_img" href="<?=  $this->router->generateRoute('posts', array('categoryId' => 2, 'pageId' => 1)); ?>"></a>
            <a class="footer_img" id="js_img" href="<?=   $this->router->generateRoute('posts', array('categoryId' => 3, 'pageId' => 1)); ?>"></a>
            <a class="footer_img" id="php_img" href="<?=  $this->router->generateRoute('posts', array('categoryId' => 4, 'pageId' => 1)); ?>"></a>
        </div>
        <div class="clear"></div>
    </div>
    <div class="footer-middle">
        <img id="footer-img" class="hidden-xs hidden-sm hidden-md" src="/web/images/web-footer.png" />

        <div id="footer-first-block">
            <h2>Contact us</h2>

            <div>
                <img id="phone-img" src="/web/images/phone_white.png" />(096) 374-9502
            </div>
            <br/>

            <div>
                <img id="envelope-img" src="/web/images/envelope.png"/>i.i.babko@gmail.com
            </div>
        </div>
        <div id="footer-second-block">
            <h2>Websites</h2>

            <div class="list-group site_links">
                <a class="list-group-item" target="_blank" href="http://www.sitepoint.com">SitePoint</a>
                <a class="list-group-item" target="_blank" href="http://tympanus.net/codrops/">Tympanus</a>
                <a class="list-group-item" target="_blank" href="http://tutsplus.com">TutsPlus</a>
                <a class="list-group-item" target="_blank" href="https://phpacademy.org">PhpAcademy</a>
                <a class="list-group-item" target="_blank" href="http://www.codecademy.com">CodeAcademy</a>
            </div>
        </div>
        <div id="footer-third-block">
            <h2>YouTube channels</h2>

            <div class="list-group channel_links">
                <a class="list-group-item" target="_blank" href="https://www.youtube.com/user/phpacademy">PhpAcademy</a>
                <a class="list-group-item" target="_blank" href="https://www.youtube.com/user/DevTipsForDesigners">DevTips</a>
                <a class="list-group-item" target="_blank"
                   href="https://www.youtube.com/user/LevelUpTuts">LevelUpTuts</a>
                <a class="list-group-item" target="_blank"
                   href="https://www.youtube.com/channel/UCJbPGzawDH1njbqV-D5HqKw">TheNewBoston</a>
                <a class="list-group-item" target="_blank" href="https://www.youtube.com/user/derekbanas">DerekBanas</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <img src="/web/images/copyright.png" alt="copyright">2015. All rights reserved.
    </div>
</div>


<script type="application/javascript" src="/web/js/jquery.min.js"></script>
<script type="application/javascript" src="/web/js/bootstrap.min.js"></script>
<script type="application/javascript" src="/web/js/jquery.hotkeys.js"></script>
<script type="application/javascript" src="/web/js/bootstrap-wysiwyg.js"></script>
<script type="application/javascript" src="/web/js/script.js"></script>

<!-- CodeMirror -->
<script type="application/javascript" src="/web/js/codeMirror/codemirror.js"></script>
<script type="application/javascript" src="/web/js/codeMirror/matchbrackets.js"></script>
<script type="application/javascript" src="/web/js/codeMirror/htmlmixed.js"></script>
<script type="application/javascript" src="/web/js/codeMirror/xml.js"></script>
<script type="application/javascript" src="/web/js/codeMirror/javascript.js"></script>
<script type="application/javascript" src="/web/js/codeMirror/css.js"></script>
<script type="application/javascript" src="/web/js/codeMirror/clike.js"></script>
<script type="application/javascript" src="/web/js/codeMirror/php.js"></script>
<!-- End CodeMirror -->

</body>
</html>