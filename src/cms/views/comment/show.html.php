<div class="panel panel-black">
    <div class="panel-heading">
        <h3 class="panel-title">Comment №<?= $this->comment->getId(); ?></h3>
    </div>
    <div class="panel-body">
        <p><b>Author:</b> <?= $this->comment->getAuthor(); ?></p>

        <p><b>Post:</b> <?= $this->comment->getPostTitle(); ?></p>

        <p><b>Text:</b><br/>"<?= $this->comment->getText(); ?>"</p>

        <p><b>Created date:</b> <?= $this->comment->getCreatedDate(); ?></p>
        <a class='btn btn-default' role='button'
           href='<?= $this->router->generateRoute('show_comments', array('pageId' => 1)); ?>'>Back</a>
    </div>
</div>