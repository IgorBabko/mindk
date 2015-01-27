<?php use Blog\Util; ?>
<form action="<?= $this->router->generateRoute('edit_post', array('id' => $this->id)); ?>" method="post" id="post_form">
    <div class="panel panel-black">
        <div class="panel-heading">
            <h3 class="panel-title">Edit post</h3>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="category">Category:</label>
                <select class="form-control" name="_category" id="category">
                    <?php foreach ($this->categories as $category) { ?>
                        <option
                            value="<?= $category['name']; ?>" <?= ($_POST['_category'] == $category['name'])?'selected':''; ?> ><?= $category['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <?php $hasError = Util::errorBox(isset($this->errors['_title'])?$this->errors['_title']:null); ?>
            <div class="form-group <?= $hasError; ?>">
                <label for="title">Title:</label>
                <input autocomplete="off" type="text" class="form-control" id="title" name="_title"
                       value="<?= $_POST['_title']; ?>"
                       placeholder="Post description">
            </div>
            <?php $hasError = Util::errorBox(isset($this->errors['_smallText'])?$this->errors['_smallText']:null); ?>
            <div class="form-group <?= $hasError; ?>">
                <label for="smallText">Short text:</label>
                <textarea rows="10" class="form-control" name="_smallText"
                          id="smallText"><?= $_POST['_smallText']; ?></textarea>
            </div>
            <?php $hasError = Util::errorBox(isset($this->errors['_text'])?$this->errors['_text']:null); ?>
            <div class="form-group <?= $hasError; ?>">
                <label for="text">Text:</label>
                <textarea rows="25" class="form-control" name="_text" id="text"><?= $_POST['_text']; ?></textarea>
            </div>
            <div id="amountOfComments">Amount of comments: <?= $_POST['_amountOfComments']; ?></div>
            <a class='btn btn-default' role='button'
               href="<?= $this->router->generateRoute('show_posts', array('pageId' => 1)); ?>">Cancel</a>
            <button type="reset" class="btn btn-primary">Reset</button>
            <button type="submit" class="btn btn-success">OK</button>
        </div>
    </div>
</form>