<?php use Blog\Util; ?>
<form action="<?= $this->router->generateRoute('add_comment'); ?>" method="post"
      id="comment_form">
    <div class="panel panel-black">
        <div class="panel-heading">
            <h3 class="panel-title">Add comment</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="postTitle">Post:</label>
                <select class="form-control" name="_postTitle" id="postTitle">
                    <?php foreach ($this->posts as $post) { ?>
                        <option
                            value="<?= $post['title']; ?>" <?= (isset($_POST['_postTitle']) && $_POST['_postTitle'] === $post['title'])?'selected':''; ?> ><?= $post['title']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <?php $hasError = Util::errorBox(isset($this->errors['_text'])?$this->errors['_text']:null); ?>
            <div class="form-group <?= $hasError; ?>">
                <label for="text">Text:</label>
                <textarea name="_text" id="text" placeholder="Enter text of the comment"
                          class="form-control"><?= isset($_POST['_text'])?$_POST['_text']:''; ?></textarea>
            </div>
            <?php $hasError = Util::errorBox(isset($this->errors['_author'])?$this->errors['_author']:null); ?>
            <div class="form-group <?= $hasError; ?>">
                <label for="author">Author:</label>
                <input autocomplete="off" type="text" class="form-control" id="author" name="_author"
                       value="<?= isset($_POST['_author'])?$_POST['_author']:''; ?>"
                       placeholder="Author of the comment">
            </div>
            <a class='btn btn-default' role='button'
               href="<?= $this->router->generateRoute('show_comments', array('pageId' => 1)); ?>">Cancel</a>
            <button type="reset" class="btn btn-primary">Reset</button>
            <button type="submit" class="btn btn-success">OK</button>
        </div>
    </div>
</form>