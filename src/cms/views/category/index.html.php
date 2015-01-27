<div id="table_div">
    <?= $this->pagination; ?>
    <table class="table cms_table">
        <thead>
        <?= isset($_SESSION['searchCategoryQuery'])?"<tr><td colspan='2'></td><td colspan='2' id='search_result' class='link_button'>$this->searchResult</td></tr>":''; ?>
        <tr>
            <td>#</td>
            <td>Title</td>
            <td colspan="2">
                <a id="add_category_button" class='btn btn-success' role='button'
                   href='<?= $this->router->generateRoute('add_category'); ?>'>New category</a>
            </td>
        </tr>
        <tr>
            <form action="<?= $this->router->generateRoute('show_categories', array('pageId' => 1)); ?>" method="post"
                  id="cms_search_form">
                <td class="search-id">
                    <input autocomplete="off" id="search_id" type="text" class="form-control" name="_id"
                           value="<?= isset($_POST['_id'])?$_POST['_id']:''; ?>">
                </td>
                <td>
                    <input autocomplete="off" id="search_title" type="text" class="form-control" name="_name"
                           value="<?= isset($_POST['_id'])?$_POST['_name']:''; ?>">
                </td>
                <td>
                    <a class='btn btn-warning' role='button' onclick="$('#cms_search_form').submit();"
                       href="javascript:void(0)">Search</a>
                </td>
            </form>
            <form id="reset_form" action="<?= $this->router->generateRoute('show_categories', array('pageId' => 1)); ?>"
                  method="post">
                <td>
                    <input id="search_reset" type="hidden" name="search_category_reset">
                    <button type="submit"
                            class="btn btn-default" <?= isset($_SESSION['searchCategoryQuery'])?'':'disabled'; ?>>Reset
                    </button>
                </td>
            </form>

        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($this->categories as $category) {
            echo '<tr>';
            foreach ($category as $item) {
                echo '<td>'.$item.'</td>';
            }
            echo "<td class='link_button'><a class='btn btn-primary' role='button' href='".$this->router->generateRoute(
                    'edit_category',
                    array('id' => $category['id'])
                )."'>Edit</a></td>";
            echo "<td class='link_button'><a class='btn btn-danger' role='button' href='".$this->router->generateRoute(
                    'delete_category',
                    array('id' => $category['id'])
                )."'>Delete</a></td>";
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
    <?= $this->pagination; ?>
</div>