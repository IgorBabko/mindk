<?= $this->pagination; ?>
<?php foreach ($this->posts as $post) { ?>
    <div class="panel panel-black post-container">
        <div class="panel-heading panel-title">
            <?= $post['title']; ?><p class="text-right post-title">
                <i>Comments: <?= $post['amount_of_comments']; ?> | Date: <?= $post['posted_date']; ?></i></p>
        </div>
        <div class="panel-body">
            <?= html_entity_decode($post['small_text']); ?>
        </div>
        <div class="panel-footer post-footer">
            <a class='btn btn-default' role='button'
               href='<?= $this->router->generateRoute('post', array('id' => $post['id'])); ?>'>Read more</a>
        </div>
    </div>
<?php } ?>
<?= $this->pagination; ?>