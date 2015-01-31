<?php use Blog\Util; ?>
<form action="<?= $this->router->generateRoute('change_password'); ?>" method="post" id="signup-form"
      novalidate>
    <div class="panel panel-black">
        <div class="panel-heading">
            <h3 class="panel-title">Change password</h3>
        </div>
        <div class="panel-body">
            <?php $hasError = Util::errorBox(isset($this->errors['_password']) ? $this->errors['_password'] : null); ?>
            <div class="form-group <?= $hasError; ?>">
                <label for="password">New password:</label>
                <input autocomplete="off" type="password" class="form-control" name="_password" id="password"
                       placeholder="Password">
            </div>
            <div class="form-group <?= $hasError; ?>">
                <label for="confirmation">Confirm new password:</label>
                <input autocomplete="off" type="password" class="form-control" name="_confirmation" id="confirmation"
                       placeholder="Confirm password">
            </div>
            <hr/>
            <div class="form-group">
                <label for="password">Current password:</label>
                <input autocomplete="off" type="password" class="form-control" name="current_password"
                       id="current_password"
                       placeholder="Current password">
            </div>
            <a class='btn btn-default' role='button' href='<?= $this->router->generateRoute('update'); ?>'>Cancel</a>
            <button type="reset" class="btn btn-primary">Reset</button>
            <button type="submit" class="btn btn-success">Change</button>
        </div>
    </div>
</form>