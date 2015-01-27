<div class="panel panel-black">
    <div class="panel-heading">
        <h3 class="panel-title">User №<?= $this->user->getId(); ?></h3>
    </div>
    <div class="panel-body">
        <img class="cms-user-picture" src="<?= $this->user->getPicturePath(); ?>"/>

        <p><b>Username:</b> <?= $this->user->getUsername(); ?></p>

        <p><b>Email:</b> <?= $this->user->getEmail(); ?></p>

        <p><b>JoinedDate:</b> <?= $this->user->getJoinedDate(); ?></p>
        <a class='btn btn-default' role='button'
           href='<?= $this->router->generateRoute('show_users', array('pageId' => 1)); ?>'>Back</a>
    </div>
</div>