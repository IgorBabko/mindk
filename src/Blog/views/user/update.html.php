<?php use Blog\Util; ?>
<form action="<?= $this->router->generateRoute('update'); ?>" method="post" enctype="multipart/form-data"
      id="signup-form" novalidate>
    <div class="panel panel-black">
        <div class="panel-heading">
            <h3 class="panel-title">Update profile</h3>
        </div>
        <div class="panel-body">
            <?php $hasError = Util::errorBox(isset($this->errors['_username'])?$this->errors['_username']:null); ?>
            <div class="form-group <?= $hasError; ?>">
                <label for="username">Username:</label>
                <input autocomplete="off" type="text" class="form-control" name="_username" id="username"
                       placeholder="Username"
                       value="<?= $_POST['_username']; ?>">
            </div>
            <?php $hasError = Util::errorBox(isset($this->errors['_email'])?$this->errors['_email']:null); ?>
            <div class="form-group <?= $hasError; ?>">
                <label for="email">Email:</label>
                <input autocomplete="off" type="email" class="form-control" name="_email" id="email"
                       placeholder="Email address"
                       value="<?= $_POST['_email']; ?>">
            </div>
            <?php $hasError = Util::errorBox(($this->wrongFile != null)?$this->wrongFile:null); ?>
            <div class="<?= $hasError; ?>">
                <label for="profile_image">Profile picture:</label><br/>
                <span class="btn btn-default btn-file">
                    Browse<input type="file" name="profile_image" id="profile_image">
                </span>
            </div>
            <br/>
            <a class='btn btn-default' role='button' href='<?= $this->router->generateRoute('home'); ?>'>Cancel</a>
            <a class='btn btn-primary' role='button' href='<?= $this->router->generateRoute('change_password'); ?>'>Change
                password</a>
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </div>
</form>