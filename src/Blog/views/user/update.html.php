<?php use Blog\Util; ?>
<form action="<?= $this->router->generateRoute('update'); ?>" method="post" id="signup-form" novalidate>
    <h1>Update profile</h1>
    <?php $hasError = Util::errorBox(isset($this->errors['_username'])?$this->errors['_username']:null); ?>
    <div class="form-group <?= $hasError; ?>">
        <label for="username">Username:</label>
        <input autocomplete="off" type="text" class="form-control" name="_username" id="username" placeholder="Username"
               value="<?= $_POST['_username']; ?>">
    </div>
    <?php $hasError = Util::errorBox(isset($this->errors['_email'])?$this->errors['_email']:null); ?>
    <div class="form-group <?= $hasError; ?>">
        <label for="email">Email:</label>
        <input autocomplete="off" type="email" class="form-control" name="_email" id="email" placeholder="Email address"
               value="<?= $_POST['_email']; ?>">
    </div>
    <a class='btn btn-default' role='button' href='<?= $this->router->generateRoute('home'); ?>'>Cancel</a>
    <a class='btn btn-primary' role='button' href='<?= $this->router->generateRoute('change_password'); ?>'>Change
        password</a>
    <button type="submit" class="btn btn-success">Update</button>
</form>