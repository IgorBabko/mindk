<div id="table_div">
    <?= $this->pagination; ?>
    <table class="table cms_table">
        <thead>
        <?= isset($_SESSION['searchPostQuery']) ? "<tr><td colspan='3'></td><td colspan='2' id='search_result' class='link_button'>$this->searchResult</td></tr>" : ''; ?>
        <tr>
            <td>#</td>
            <td>Category</td>
            <td>Title</td>
            <td colspan="2">
                <a id="add_post_button" class='btn btn-success' role='button'
                   href='<?= $this->router->generateRoute('add_post'); ?>'>New post</a>
            </td>
        </tr>
        <tr>
            <form action="<?= $this->router->generateRoute('show_posts', array('pageId' => 1)); ?>" method="post"
                  id="cms_search_form">
                <td class="search-id">
                    <input autocomplete="off" id="search_id" type="text" class="form-control" name="_id"
                           value="<?= isset($_POST['_id']) ? $_POST['_id'] : ''; ?>">
                </td>
                <td class=search-category">
                    <input autocomplete="off" id="search_category" type="text" class="form-control" name="_category"
                           value="<?= isset($_POST['_category']) ? $_POST['_category'] : ''; ?>">
                </td>
                <td>
                    <input autocomplete="off" id="search_title" type="text" class="form-control" name="_title"
                           value="<?= isset($_POST['_title']) ? $_POST['_title'] : ''; ?>">
                </td>
                <td>
                    <a class='btn btn-warning' role='button'
                       onclick="$('#cms_search_form').submit()" href='javascript:void(0)'>Search</a>
                </td>
            </form>
            <td>
                <form id="reset_form" action="<?= $this->router->generateRoute('show_posts', array('pageId' => 1)); ?>"
                      method="post">
                    <input id="search_reset" type="hidden" name="search_post_reset">
                    <button type="submit"
                            class="btn btn-default" <?= isset($_SESSION['searchPostQuery']) ? '' : 'disabled'; ?>>Reset
                    </button>
                </form>
            </td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($this->posts as $post) {
            echo '<tr>';
            foreach ($post as $item) {
                echo '<td>' . $item . '</td>';
            }
            echo "<td class='link_button'><a class='btn btn-primary' role='button' href='" . $this->router->generateRoute(
                    'edit_post',
                    array('id' => $post['id'])
                ) . "'>Edit</a></td>";
            echo "<td class='link_button'><a class='btn btn-danger' role='button' href='" . $this->router->generateRoute(
                    'delete_post',
                    array('id' => $post['id'])
                ) . "'>Delete</a></td>";
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
    <?= $this->pagination; ?>
</div>