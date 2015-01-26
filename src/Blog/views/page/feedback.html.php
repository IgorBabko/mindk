<?php use Blog\Util; ?>
<form action="<?= $this->router->generateRoute('feedback'); ?>" method="post" id="feedback-form" novalidate>
    <h1>Feedback</h1>
    <?php $hasError = Util::errorBox(isset($this->errors['_username'])?$this->errors['_username']:null); ?>
    <div class="form-group <?= $hasError; ?>">
        <label for="username">Username:</label>
        <input autocomplete="off" type="text" class="form-control" name="_username" id="username" placeholder="Your name"
               value="<?= isset($_POST['_username'])?$_POST['_username']:''; ?>">
    </div>
    <?php $hasError = Util::errorBox(isset($this->errors['_email'])?$this->errors['_email']:null); ?>
    <div class="form-group <?= $hasError; ?>">
        <label for="email">Email:</label>
        <input autocomplete="off" type="email" class="form-control" name="_email" id="email" placeholder="Email address"
               value="<?= isset($_POST['_email'])?$_POST['_email']:''; ?>">
    </div>
    <?php $hasError = Util::errorBox(isset($this->errors['_text'])?$this->errors['_text']:null); ?>
    <label for="text">Message:</label>
    <textarea class="form-control <?= $hasError; ?>" id="text"
              name="text"><?= isset($_POST['_text'])?$_POST['_text']:''; ?></textarea>
    <button type="submit" class="btn btn-success">Submit</button>
</form>