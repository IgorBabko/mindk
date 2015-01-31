<?php
$isRouteActive = function ($currentRoute) {
    return ($this->activeRoute === $currentRoute) ? 'class="active"' : '';
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
    <link href="/web/css/codeMirror/themes/twilight.css" type="text/css" rel="stylesheet"/>
    <link href="/web/css/codeMirror/themes/monokai.css" type="text/css" rel="stylesheet"/>
    <!-- End CodeMirror -->

    <link href="/web/css/reset.css" rel="stylesheet">
    <link href="/web/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
    <link href="/web/css/bootstrap-theme.min.css" type="text/css" rel="stylesheet"/>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet"/>

    <link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700'
          rel='stylesheet' type='text/css'/>
    <link href="/web/css/theme.css" rel="stylesheet"/>
</head>

<body role="document" id="cms">

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
                <li <?= $isRouteActive('show_users'); ?> ><a
                        href="<?= $this->router->generateRoute('show_users', array('pageId' => 1)); ?>">Users</a></li>
                <li <?= $isRouteActive('show_posts'); ?> ><a
                        href="<?= $this->router->generateRoute('show_posts', array('pageId' => 1)); ?>">Posts</a>
                </li>
                <li <?= $isRouteActive('show_categories'); ?> ><a
                        href="<?= $this->router->generateRoute('show_categories', array('pageId' => 1)); ?>">Categories</a>
                </li>
                <li <?= $isRouteActive('show_comments'); ?> ><a
                        href="<?= $this->router->generateRoute('show_comments', array('pageId' => 1)); ?>">Comments</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?= $this->router->generateRoute('home', array('pageId' => 1)); ?>">Quit</a></li>
            </ul>
        </div>
    </div>
</nav>

<div id="under_navbar"></div>
<div id="header">
    <img src="/web/images/web_header.jpg">
</div>

<div id="main_container">
    <div id="content-dashboard">
        <?php
        if (isset($_SESSION['flashMsgs'])) {
            foreach ($_SESSION['flashMsgs'] as $message) {
                echo $message;
            }
            unset($_SESSION['flashMsgs']);
        }

        echo $this->view;
        ?>
    </div>
    <div class="clear"></div>
</div>

<div class="scrollToTop">
    <img id="arrow_up" src="/web/images/arrow_up.png">
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