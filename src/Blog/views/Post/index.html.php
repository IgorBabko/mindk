<?= $this->pagination; ?>
<?php foreach ($this->posts as $post) { ?>
    <div style="color: black; background-color: rgb(245,245,245);" class="panel panel-black">
        <div class="panel-heading panel-title">
            <?= $post['title']; ?><p class="text-right" style="font-size: 12px; padding: 0; margin: 0;">
                <i>Comments: <?= $post['amount_of_comments']; ?> | Date: <?= $post['posted_date']; ?></i></p>
        </div>
        <div class="panel-body">
            <?= html_entity_decode($post['small_text']); ?>
        </div>
        <div class="panel-footer" style="text-align: right;">
            <a class='btn btn-default' style="color: black;" role='button'
               href='<?= $this->router->generateRoute('post', array('id' => $post['id'])); ?>'>Read more</a>
        </div>
    </div>
<?php } ?>
<?= $this->pagination; ?>