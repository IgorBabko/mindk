<div id="table_div">
    <?= $this->pagination; ?>
    <table class="table cms_table">
        <thead>
        <?= isset($_SESSION['searchCommentQuery'])?"<tr><td colspan='3'></td><td colspan='2' id='search_result' class='link_button'>$this->searchResult</td></tr>":''; ?>
        <tr>
            <td>#</td>
            <td>Author</td>
            <td>Post title</td>
            <td colspan="2">
                <a id="add_comment_button" class='btn btn-success' role='button'
                   href='<?= $this->router->generateRoute('add_comment'); ?>'>New comment</a>
            </td>
        </tr>
        <tr>
            <form action="<?= $this->router->generateRoute('show_comments', array('pageId' => 1)); ?>" method="post"
                  id="cms_search_form">
                <td class="search-id">
                    <input autocomplete="off" id="search_id" type="text" class="form-control" name="_id"
                           value="<?= isset($_POST['_id'])?$_POST['_id']:''; ?>">
                </td>
                <td>
                    <input autocomplete="off" id="search_author" type="text" class="form-control" name="_author"
                           value="<?= isset($_POST['_author'])?$_POST['_author']:''; ?>">
                </td>
                <td>
                    <input autocomplete="off" id="search_post_title" type="text" class="form-control" name="_postTitle"
                           value="<?= isset($_POST['_postTitle'])?$_POST['_postTitle']:''; ?>">
                </td>
                <td>
                    <a class='btn btn-warning' role='button' onclick="$('#cms_search_form').submit();"
                       href="javascript:void(0)">Search</a>
                </td>
            </form>
            <td>
                <form id="reset_form"
                      action="<?= $this->router->generateRoute('show_comments', array('pageId' => 1)); ?>"
                      method="post">
                    <input id="search_reset" type="hidden" name="search_comment_reset">
                    <button type="submit"
                            class="btn btn-default" <?= isset($_SESSION['searchCommentQuery'])?'':'disabled'; ?>>Reset
                    </button>
                </form>
            </td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($this->comments as $comment) {
            echo '<tr>';
            foreach ($comment as $item) {
                echo '<td>'.$item.'</td>';
            }
            echo "<td class='link_button'><a class='btn btn-primary' role='button' href='".$this->router->generateRoute(
                    'show_comment',
                    array('id' => $comment['id'])
                )."'>Show</a></td>";
            echo "<td class='link_button'><a class='btn btn-danger' role='button' href='".$this->router->generateRoute(
                    'delete_comment',
                    array('id' => $comment['id'])
                )."'>Delete</a></td>";
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
    <?= $this->pagination; ?>
</div>