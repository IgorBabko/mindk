<?php use Blog\Util; ?>
<form action="<?= $this->router->generateRoute('edit_category', array('id' => $this->id)); ?>" method="post"
      id="category_form">
    <div class="panel panel-black">
        <div class="panel-heading">
            <h3 class="panel-title">Edit category</h3>
        </div>
        <div class="panel-body">
            <?php $hasError = Util::errorBox(isset($this->errors['_name'])?$this->errors['_name']:null); ?>
            <div class="form-group <?= $hasError; ?>">
                <label for="name">Name:</label>
                <input autocomplete="off" type="text" class="form-control" id="name" name="_name"
                       value="<?= $_POST['_name']; ?>"
                       placeholder="Enter category name">
            </div>
            <a class='btn btn-default' role='button'
               href="<?= $this->router->generateRoute('show_categories', array('pageId' => 1)); ?>">Cancel</a>
            <button type="reset" class="btn btn-primary">Reset</button>
            <button type="submit" class="btn btn-success">OK</button>
        </div>
    </div>
</form>