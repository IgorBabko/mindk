<div id="table_div">
    <?= $this->pagination; ?>
    <table class="table cms_table">
        <thead>
        <?= isset($_SESSION['searchUserQuery'])?"<tr><td colspan='3'></td><td colspan='2' id='search_result' class='link_button'>$this->searchResult</td></tr>":''; ?>
        <tr>
            <td>#</td>
            <td>Username</td>
            <td>Email</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <form action="<?= $this->router->generateRoute('show_users', array('pageId' => 1)); ?>" method="post"
                  id="cms_search_form">
                <td class="search-id">
                    <input autocomplete="off" id="search_id" type="text" class="form-control" name="_id"
                           value="<?= isset($_POST['_id'])?$_POST['_id']:''; ?>">
                </td>
                <td>
                    <input autocomplete="off" id="search_username" type="text" class="form-control" name="_username"
                           value="<?= isset($_POST['_username'])?$_POST['_username']:''; ?>">
                </td>
                <td>
                    <input autocomplete="off" id="search_email" type="text" class="form-control" name="_email"
                           value="<?= isset($_POST['_email'])?$_POST['_email']:''; ?>">
                </td>
                <td class="link_button">
                    <a class='btn btn-warning' role='button' onclick="$('#cms_search_form').submit();"
                       href="javascript:void(0)">Search</a>
                </td>
            </form>
            <td>
                <form id="reset_form" action="<?= $this->router->generateRoute('show_users', array('pageId' => 1)); ?>"
                      method="post">
                    <input id="search_reset" type="hidden" name="search_user_reset">
                    <button type="submit"
                            class="btn btn-default" <?= isset($_SESSION['searchUserQuery'])?'':'disabled'; ?>>Reset
                    </button>
                </form>
            </td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($this->users as $user) {
            echo '<tr>';
            foreach ($user as $item) {
                echo '<td>'.$item.'</td>';
            }
            echo "<td class='link_button'><a class='btn btn-primary' role='button' href='".$this->router->generateRoute(
                    'show_user',
                    array('id' => $user['id'])
                )."'>Show</a></td>";
            echo "<td class='link_button'><a class='btn btn-danger' role='button' href='".$this->router->generateRoute(
                    'delete_user',
                    array('id' => $user['id'])
                )."'>Delete</a></td>";
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
    <?= $this->pagination; ?>
</div>