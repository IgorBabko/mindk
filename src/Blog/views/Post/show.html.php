<?php $post = $this->post; ?>
    <div class="panel panel-black post-block">
        <div class="panel-heading panel-title">
            <?= $post->getTitle(); ?><p class="text-right" style="font-size: 12px; padding: 0; margin: 0;">
                <i><?= 'Date: '.$post->getPostedDate(); ?></i></p>
        </div>
        <div class="panel-body post-body">
            <?= html_entity_decode($post->getText()); ?>
        </div>
        <div class="panel-footer" style="text-align: right;">
            <a class='btn btn-default' style="color: black;" role='button'
               href='<?= isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"/posts/0/1"; ?>'>Back</a>
        </div>
    </div>
    <h2>Comments(<?= $post->getAmountOfComments(); ?>):</h2>
<?php if (isset($_SESSION['user'])) { ?>

    <div id="comment_container">
        <input type="hidden" id="commentPost" value="<?= $post->getTitle(); ?>"/>
        <textarea style="display: none;" id="hiddenEditor"></textarea>

        <div>
            <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
                <div class="btn-group">
                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Font"><i
                            class="icon-font"></i><b
                            class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a data-edit="fontName Arial">Arial</a></li>
                        <li><a data-edit="fontName Calibri">Calibri</a></li>
                        <li><a data-edit="fontName Consolas">Consolas</a></li>
                        <li><a data-edit="fontName Georgia">Georgia</a></li>
                        <li><a data-edit="fontName Verdana">Verdana</a></li>
                    </ul>
                </div>
                <div class="btn-group">
                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Font Size"><i
                            class="icon-text-height"></i><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
                        <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                        <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
                    </ul>
                </div>
                <div class="btn-group">
                    <a class="btn btn-default" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
                    <a class="btn btn-default" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i
                            class="icon-italic"></i></a>
                    <a class="btn btn-default" data-edit="strikethrough" title="Strikethrough"><i
                            class="icon-strikethrough"></i></a>
                    <a class="btn btn-default" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i
                            class="icon-underline"></i></a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-default" data-edit="insertunorderedlist" title="Bullet list"><i
                            class="icon-list-ul"></i></a>
                    <a class="btn btn-default" data-edit="insertorderedlist" title="Number list"><i
                            class="icon-list-ol"></i></a>
                    <a class="btn btn-default" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i
                            class="icon-indent-left"></i></a>
                    <a class="btn btn-default" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-default" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i
                            class="icon-align-left"></i></a>
                    <a class="btn btn-default" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i
                            class="icon-align-center"></i></a>
                    <a class="btn btn-default" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i
                            class="icon-align-right"></i></a>
                    <a class="btn btn-default" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i
                            class="icon-align-justify"></i></a>
                </div>
                <div class="btn-group">
                    <a class="btn btn-default" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
                    <a class="btn btn-default" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i
                            class="icon-repeat"></i></a>
                </div>
            </div>

            <div id="editor">
            </div>
        </div>
        <div style="text-align: right; margin: 5px 0;">
            <button id="commentButton" type="button" class="btn btn-success" disabled>Comment</button>
        </div>
    </div>
<hr />
<?php } else { ?>
    <div class='well well-sm' id="registerToLeaveComment">Only registered users can add comments!</div>
<?php } ?>
<?php
foreach ($this->comments as $comment) { ?>
    <div class="panel panel-default">
        <div class="panel-heading panel-title" style="font-size: 18px; padding: 10px 5px 0 5px;">
            <p style="float: left;"><?= $comment['author']; ?></p>
            <sub style='float: right; font-size: 12px; font-style: italic;'><?= $comment['created_date']; ?></sub>
            <div class="clear"></div>
        </div>
        <div class="panel-body" style="padding: 20px;">
            <?= $comment['text']; ?>
        </div>

        <?php
            if (isset($_SESSION['user']) && $_SESSION['user']['name'] == $comment['author']) {

                echo <<<HERE
                    <div class="panel-footer" style="text-align: right; padding: 0;;">
                        <button style="width: 70px; margin: 4px 2px" type="button" class="btn btn-danger delete_comment_button">Delete</button>
                    </div>
HERE;
            }
        ?>
    </div>
<?php } ?>