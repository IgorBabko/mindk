<?php use Blog\Util; ?>
<form action="<?= $this->router->generateRoute('signup'); ?>" method="post" enctype="multipart/form-data"
      id="signup-form" novalidate>
    <div class="panel panel-black">
        <div class="panel-heading">
            <h3 class="panel-title">Registration</h3>
        </div>
        <div class="panel-body">
            <?php $hasError = Util::errorBox(isset($this->errors['_username']) ? $this->errors['_username'] : null); ?>
            <div class="form-group <?= $hasError ?>">
                <label for="username">Username:</label>
                <input autocomplete="off" type="text" class="form-control" name="_username" id="username"
                       placeholder="Username"
                       value="<?= isset($_POST['_username']) ? $_POST['_username'] : ''; ?>">
            </div>
            <?php $hasError = Util::errorBox(isset($this->errors['_password']) ? $this->errors['_password'] : null); ?>
            <div class="form-group <?= $hasError; ?>">
                <label for="password">Password:</label>
                <input autocomplete="off" type="password" class="form-control" name="_password" id="password"
                       placeholder="Password">
            </div>
            <div class="form-group <?= $hasError; ?>">
                <label for="confirmation">Confirm password:</label>
                <input autocomplete="off" type="password" class="form-control" name="confirmation" id="confirmation"
                       placeholder="Confirm password">
            </div>
            <?php $hasError = Util::errorBox(isset($this->errors['_email']) ? $this->errors['_email'] : null); ?>
            <div class="form-group <?= $hasError; ?>">
                <label for="email">Email:</label>
                <input autocomplete="off" type="email" class="form-control" name="_email" id="email"
                       placeholder="Email address"
                       value="<?= isset($_POST['_email']) ? $_POST['_email'] : ''; ?>">
            </div>
            <?php $hasError = Util::errorBox(($this->wrongFile != null) ? $this->wrongFile : null); ?>
            <div class="<?= $hasError; ?>">
                <label for="profile_image">Choose profile picture:</label><br/>
                <span class="btn btn-default btn-file">
                    Browse<input type="file" name="profile_image" id="profile_image">
                </span>
            </div>
            <br/>
            <a class='btn btn-default' role='button'
               href='<?= $this->router->generateRoute('home', array('pageId' => 1)); ?>'>Cancel</a>
            <button type="reset" class="btn btn-info">Reset</button>
            <button type="submit" class="btn btn-success">Sign up</button>
        </div>
    </div>
</form>

